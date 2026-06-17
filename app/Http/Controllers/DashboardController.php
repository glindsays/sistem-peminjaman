<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanRuang;
use App\Models\PeminjamanBarang;
use App\Models\Ruang;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function mahasiswa()
    {
        $userId = Auth::id();

        $pendingRuang = PeminjamanRuang::where('user_id', $userId)->where('status_izin', 'Pending')->count();
        $approvedRuang = PeminjamanRuang::where('user_id', $userId)->where('status_izin', 'Disetujui')->count();
        $rejectedRuang = PeminjamanRuang::where('user_id', $userId)->where('status_izin', 'Ditolak')->count();

        $pendingBarang = PeminjamanBarang::where('user_id', $userId)->where('status_izin', 'Pending')->count();
        $approvedBarang = PeminjamanBarang::where('user_id', $userId)->where('status_izin', 'Disetujui')->count();
        $rejectedBarang = PeminjamanBarang::where('user_id', $userId)->where('status_izin', 'Ditolak')->count();

        $totalPending = $pendingRuang + $pendingBarang;
        $totalApproved = $approvedRuang + $approvedBarang;
        $totalRejected = $rejectedRuang + $rejectedBarang;
        $totalPeminjaman = $totalPending + $totalApproved + $totalRejected;

        $riwayatRuang = PeminjamanRuang::where('user_id', $userId)
            ->with('ruang')
            ->orderBy('tgl_peminjaman', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Ruangan';
                $item->nama_fasilitas = $item->ruang->nama_ruangan ?? 'N/A';
                return $item;
            });

        $riwayatBarang = PeminjamanBarang::where('user_id', $userId)
            ->with('barang')
            ->orderBy('tgl_peminjaman', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Barang';
                $item->nama_fasilitas = $item->barang->nama_barang ?? 'N/A';
                return $item;
            });

        $riwayatGabungan = $riwayatRuang->concat($riwayatBarang)
            ->sortByDesc('tgl_peminjaman')
            ->take(5);

        return view('mahasiswa.dashboard', compact(
            'totalPeminjaman',
            'totalPending',
            'totalApproved',
            'totalRejected',
            'riwayatGabungan'
        ));
    }

    public function riwayatMahasiswa(Request $request)
    {
        $userId = Auth::id();
        
        $tabAktif = $request->query('tab', 'ruang');

        $riwayatRuang = PeminjamanRuang::where('user_id', $userId)
            ->with('ruang')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page_ruang') 
            ->appends(['tab' => 'ruang']);

        $riwayatBarang = PeminjamanBarang::where('user_id', $userId)
            ->with('barang')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page_barang') 
            ->appends(['tab' => 'barang']);

        return view('mahasiswa.riwayat', compact('riwayatRuang', 'riwayatBarang', 'tabAktif'));
    }

    public function dosen()
    {
        $pendingRuang = PeminjamanRuang::where('status_izin', 'Pending')->count();
        $approvedRuang = PeminjamanRuang::where('status_izin', 'Disetujui')->count();
        $rejectedRuang = PeminjamanRuang::where('status_izin', 'Ditolak')->count();

        $pendingBarang = PeminjamanBarang::where('status_izin', 'Pending')->count();
        $approvedBarang = PeminjamanBarang::where('status_izin', 'Disetujui')->count();
        $rejectedBarang = PeminjamanBarang::where('status_izin', 'Ditolak')->count();

        $totalPending = $pendingRuang + $pendingBarang;
        $totalApproved = $approvedRuang + $approvedBarang;
        $totalRejected = $rejectedRuang + $rejectedBarang;
        $totalPengajuan = $totalPending + $totalApproved + $totalRejected;

        $antreanRuang = PeminjamanRuang::with(['user', 'ruang'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Ruangan';
                $item->nama_fasilitas = $item->ruang->nama_ruangan ?? 'N/A';
                return $item;
            });

        $antreanBarang = PeminjamanBarang::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Barang';
                $item->nama_fasilitas = $item->barang->nama_barang ?? 'N/A';
                return $item;
            });

        $antreanMasuk = $antreanRuang->concat($antreanBarang)
            ->sort(function ($a, $b) {
                if ($a->status_izin === 'Pending' && $b->status_izin !== 'Pending') return -1;
                if ($a->status_izin !== 'Pending' && $b->status_izin === 'Pending') return 1;
                return $b->created_at <=> $a->created_at;
            })
            ->take(5);

        return view('dosen.dashboard', compact('totalPengajuan','totalPending','totalApproved','totalRejected','antreanMasuk'));
    }

    public function riwayatDosen(Request $request)
    {
        $tabAktif = $request->query('tab', 'ruang');

        $riwayatRuang = PeminjamanRuang::with(['user', 'ruang'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page_ruang')
            ->appends(['tab' => 'ruang']);

        $riwayatBarang = PeminjamanBarang::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page_barang')
            ->appends(['tab' => 'barang']);

        return view('dosen.riwayat', compact('riwayatRuang', 'riwayatBarang', 'tabAktif'));
    }

    public function admin()
    {
        // Statistik untuk 4 Card
        $pendingRuang = PeminjamanRuang::where('status_izin', 'Pending')->count();
        $pendingBarang = PeminjamanBarang::where('status_izin', 'Pending')->count();
        $totalPending = $pendingRuang + $pendingBarang;

        // Tambahan untuk Card sesuai proposal
        $totalRuangan = Ruang::count();
        $totalBarang = Barang::count();
        $totalUser = User::count();

        // Data untuk Tabel Antrean (logika lamamu)
        $antreanRuang = PeminjamanRuang::with(['user', 'ruang'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Ruangan';
                $item->nama_fasilitas = $item->ruang->nama_ruangan ?? 'N/A';
                return $item;
            });

        $antreanBarang = PeminjamanBarang::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Barang';
                $item->nama_fasilitas = $item->barang->nama_barang ?? 'N/A';
                return $item;
            });

        $antreanMasuk = $antreanRuang->concat($antreanBarang)
            ->sort(function ($a, $b) {
                if ($a->status_izin === 'Pending' && $b->status_izin !== 'Pending') return -1;
                if ($a->status_izin !== 'Pending' && $b->status_izin === 'Pending') return 1;
                return $b->created_at <=> $a->created_at;
            })
            ->take(5);

        return view('admin.dashboard', compact(
            'totalPending', 
            'totalRuangan', 
            'totalBarang', 
            'totalUser', 
            'antreanMasuk'
        ));
    }

    public function riwayatAdmin(Request $request)
    {
        $tabAktif = $request->query('tab', 'ruang');

        $riwayatRuang = PeminjamanRuang::with(['user', 'ruang'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page_ruang')
            ->appends(['tab' => 'ruang']);

        $riwayatBarang = PeminjamanBarang::with(['user', 'barang'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page_barang')
            ->appends(['tab' => 'barang']);

        return view('admin.riwayat', compact('riwayatRuang', 'riwayatBarang', 'tabAktif'));
    }
}