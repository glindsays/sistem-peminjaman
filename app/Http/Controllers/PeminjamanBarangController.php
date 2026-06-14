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
        $pengajuan = PeminjamanBarang::with(['user', 'barang'])->latest()->get();
        return view('admin.peminjaman_barang.index', compact('pengajuan'));
    }

    public function create()
    {
        $barang = Barang::where('status', 'Tersedia')
                        ->where('jumlah', '>', 0)
                        ->get();

        return view('mahasiswa.peminjaman_barang.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'          => 'required|exists:barang,id',
            'jumlah_barang'      => 'required|integer|min:1',
            'nama_acara'         => 'required|string|max:255',
            'nama_penyelenggara' => 'required|string|max:255',
            'tgl_peminjaman'     => 'required|date|after_or_equal:today',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jumlah_barang > $barang->jumlah) {
            return back()->withInput()->withErrors([
                'jumlah_barang' => "Gagal mengajukan! Stok harian yang tersedia untuk {$barang->nama_barang} sisa {$barang->jumlah} pcs."
            ]);
        }

        PeminjamanBarang::create([
            'user_id'            => Auth::id(),
            'barang_id'          => $request->barang_id,
            'jumlah_barang'      => $request->jumlah_barang,
            'nama_acara'         => $request->nama_acara,
            'nama_penyelenggara' => $request->nama_penyelenggara,
            'tgl_peminjaman'     => $request->tgl_peminjaman,
            'status_izin'        => 'Pending',
        ]);

        return redirect()
            ->route('mahasiswa.peminjaman_barang.history')
            ->with('success', 'Pengajuan peminjaman inventaris barang berhasil dikirim!');
    }

    public function historyMahasiswa()
    {
        $history = PeminjamanBarang::with('barang')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('mahasiswa.peminjaman_barang.history', compact('history'));
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