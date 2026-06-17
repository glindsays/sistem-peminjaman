<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBarang;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanBarangController extends Controller
{
    public function index()
    {
        $pengajuan = PeminjamanBarang::with(['user', 'barang'])->latest()->paginate(10)->withQueryString();
        return view('dosen.peminjaman_barang.index', compact('pengajuan'));
    }

    public function create(Request $request)
    {
        $selectedBarangId = $request->query('barang_id');

        $barangTerpilih = null;
        if ($selectedBarangId) {
            $barangTerpilih = \App\Models\Barang::where('id', $selectedBarangId)
                                                ->where('status', 'Tersedia')
                                                ->where('jumlah', '>', 0)
                                                ->first();
        }

        $semuaBarang = \App\Models\Barang::where('status', 'Tersedia')->where('jumlah', '>', 0)->get();

        return view('mahasiswa.barang.create', compact('barangTerpilih', 'semuaBarang'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah_barang' => 'required|integer|min:1',
            'tgl_peminjaman' => 'required|date',
            'tgl_pengembalian' => 'required|date|after_or_equal:tgl_peminjaman',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        // Cek apakah barang sedang dalam maintenance (status bukan Tersedia)
        if (strtolower($barang->status) !== 'tersedia') {
            return back()->withErrors(['barang_id' => 'Barang ini sedang dalam perbaikan.']);
        }

        // Cek stok: Hitung jumlah barang yang sedang dipinjam di rentang tanggal tersebut
        $dipinjam = PeminjamanBarang::where('barang_id', $request->barang_id)
            ->where('status_izin', 'Disetujui')
            ->where('tgl_peminjaman', '<=', $request->tgl_pengembalian)
            ->where('tgl_pengembalian', '>=', $request->tgl_peminjaman)
            ->sum('jumlah_barang');

        if (($request->jumlah_barang + $dipinjam) > $barang->jumlah) {
            return back()->withInput()->withErrors(['jumlah_barang' => "Stok tidak mencukupi. Sisa tersedia: " . ($barang->jumlah - $dipinjam)]);
        }

        PeminjamanBarang::create([
            'user_id' => Auth::id(),
            'status_izin' => 'Pending',
            ...$request->all()
        ]);

        return redirect()->route('mahasiswa.barang.index')->with('success', 'Pengajuan barang dikirim!');
    }

    public function historyMahasiswa()
    {
        $history = PeminjamanBarang::with('barang')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('barang.history', compact('history'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_izin' => 'required|in:Disetujui,Ditolak',
        ]);

        $peminjaman = PeminjamanBarang::findOrFail($id);
        $barang = Barang::findOrFail($peminjaman->barang_id);

        if ($request->status_izin == 'Disetujui' && $peminjaman->jumlah_barang > $barang->jumlah) {
            return back()->with('error', 'Gagal menyetujui! Stok barang saat ini sudah tidak mencukupi.');
        }

        $peminjaman->update([
            'status_izin' => $request->status_izin
        ]);

        if ($request->status_izin == 'Disetujui') {
            $barang->decrement('jumlah', $peminjaman->jumlah_barang);
        }

        return redirect()
            ->route('dosen.peminjaman_barang.index')
            ->with('success', "Keputusan berhasil disimpan! Status pengajuan: {$request->status_izin}.");
    }
}