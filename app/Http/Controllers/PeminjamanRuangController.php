<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanRuang;
use App\Models\Ruang;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanRuangController extends Controller
{
    public function index()
    {
        $pengajuan = PeminjamanRuang::with(['user', 'ruang'])->latest()->get();
        return view('dosen.peminjaman_ruang.index', compact('pengajuan'));
    }

    public function create()
    {
        $ruangan = Ruang::where('status', 'Tersedia')->get();
        return view('mahasiswa.peminjaman_ruang.create', compact('ruangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruang_id'           => 'required|exists:ruang,id',
            'nama_acara'         => 'required|string|max:255',
            'nama_penyelenggara' => 'required|string|max:255',
            'tgl_peminjaman'     => 'required|date|after_or_equal:today',
            'waktu_mulai'        => 'required|date_format:H:i|after_or_equal:07:00|before_or_equal:22:00',
            'waktu_selesai'      => 'required|date_format:H:i|after:waktu_mulai|before_or_equal:22:00',
        ]);

        $isLibur = HariLibur::where('tanggal', $request->tgl_peminjaman)->first();
        if ($isLibur) {
            return back()->withInput()->withErrors([
                'tgl_peminjaman' => "Gagal! Tanggal tersebut adalah hari libur nasional/kampus ({$isLibur->keterangan})."
            ]);
        }

        $isBentrok = PeminjamanRuang::where('ruang_id', $request->ruang_id)
            ->where('tgl_peminjaman', $request->tgl_peminjaman)
            ->where('status_izin', '!=', 'Ditolak') 
            ->where(function ($query) use ($request) {
                $query->where('waktu_mulai', '<', $request->waktu_selesai)
                      ->where('waktu_selesai', '>', $request->waktu_mulai);
            })->exists();

        if ($isBentrok) {
            return back()->withInput()->withErrors([
                'waktu_mulai' => 'Gagal! Ruangan tersebut sudah dipesan oleh ormawa lain di jam dan tanggal yang sama.'
            ]);
        }

        PeminjamanRuang::create([
            'user_id'            => Auth::id(),
            'ruang_id'           => $request->ruang_id,
            'nama_acara'         => $request->nama_acara,
            'nama_penyelenggara' => $request->nama_penyelenggara,
            'tgl_peminjaman'     => $request->tgl_peminjaman,
            'waktu_mulai'        => $request->waktu_mulai,
            'waktu_selesai'      => $request->waktu_selesai,
            'status_izin'        => 'Pending', 
        ]);

        return redirect()->route('mahasiswa.peminjaman.history')->with('success', 'Pengajuan peminjaman ruang berhasil dikirim! Menunggu persetujuan dosen.');
    }

    public function historyMahasiswa()
    {
        $history = PeminjamanRuang::with('ruang')->where('user_id', Auth::id())->latest()->get();
        return view('mahasiswa.peminjaman_ruang.history', compact('history'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_izin' => 'required|in:Disetujui,Ditolak',
        ]);

        $peminjaman = PeminjamanRuang::findOrFail($id);
        $peminjaman->update([
            'status_izin' => $request->status_izin
        ]);

        return redirect()->route('dosen.peminjaman.index')->with('success', "Status pengajuan berhasil diubah menjadi: {$request->status_izin}!");
    }
}