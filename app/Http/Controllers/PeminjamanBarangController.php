<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBarang;
use App\Models\Barang;
use App\Models\HariLibur;
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
        if (Auth::check() && !Auth::user()->is_active) {
            return back()->withErrors(['is_active' => 'Akun Anda dinonaktifkan oleh Admin, Anda tidak dapat mengajukan peminjaman.']);
        }
        
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah_barang' => 'required|integer|min:1',
            'tgl_peminjaman' => 'required|date|after_or_equal:today',
            'tgl_pengembalian' => 'required|date|after_or_equal:tgl_peminjaman',
            'waktu_mulai' => ['required', 'date_format:H:i', 'regex:/^((0[7-9]|1[0-9]|2[0-1]):(00|30)|22:00)$/'],
            'waktu_selesai' => ['required', 'date_format:H:i', 'regex:/^((0[7-9]|1[0-9]|2[0-1]):(00|30)|22:00)$/'],
        ], [
            'waktu_mulai.regex' => 'Peminjaman hanya dapat dilakukan antara pukul 07.00 hingga 22.00 dengan kelipatan 30 menit.',
            'waktu_selesai.regex' => 'Peminjaman hanya dapat dilakukan antara pukul 07.00 hingga 22.00 dengan kelipatan 30 menit.',
            'waktu_mulai.date_format' => 'Format waktu mulai harus berupa jam:menit, misalnya 07:00 atau 07:30.',
            'waktu_selesai.date_format' => 'Format waktu pengembalian harus berupa jam:menit, misalnya 07:00 atau 07:30.',
        ]);

        $libur = HariLibur::where('tanggal', $request->tgl_peminjaman)->first();
        if ($libur) {
            return back()->withInput()->withErrors([
                'tgl_peminjaman' => "Hari Libur: {$libur->keterangan}"
            ]);
        }

        if ($request->tgl_peminjaman === $request->tgl_pengembalian) {
            if (strtotime($request->waktu_mulai) >= strtotime($request->waktu_selesai)) {
                return back()->withInput()->withErrors([
                    'waktu_selesai' => 'Waktu selesai harus setelah waktu pengambilan pada tanggal yang sama.'
                ]);
            }
        }

        $barang = Barang::findOrFail($request->barang_id);

        if (strtolower($barang->status) !== 'tersedia') {
            return back()->withErrors(['barang_id' => 'Barang ini sedang dalam perbaikan.']);
        }

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