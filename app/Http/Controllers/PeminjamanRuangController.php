<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanRuang;
use App\Models\Ruang;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PeminjamanRuangController extends Controller
{

    public function index()
    {
        $pengajuan = PeminjamanRuang::with(['user', 'ruang'])->latest()->paginate(10)->withQueryString();
        return view('dosen.peminjaman_ruang.index', compact('pengajuan'));
    }

    public function create(Request $request)
    {
        $selectedRuangId = $request->query('ruang_id');
        
        $ruangTerpilih = null;
        if ($selectedRuangId) {
            $ruangTerpilih = Ruang::where('id', $selectedRuangId)
                                  ->where('status', 'Tersedia')
                                  ->first();
        }

        $semuaRuang = Ruang::where('status', 'Tersedia')->get();

        return view('mahasiswa.ruang.create', compact('ruangTerpilih', 'semuaRuang'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->is_active) {
            return back()->withErrors(['is_active' => 'Akun Anda sedang dinonaktifkan oleh Admin. Anda tidak dapat melakukan pengajuan.']);
        }

        $request->validate([
            'ruang_id'           => 'required|exists:ruang,id',
            'nama_acara'         => 'required|string|max:255',
            'nama_penyelenggara' => 'required|string|max:255',
            'tgl_peminjaman'     => 'required|date|after_or_equal:today',
            'waktu_mulai'        => 'required|date_format:H:i',
            'waktu_selesai'      => 'required|date_format:H:i|after:waktu_mulai',
        ]);

        // $apiUrl = url('/api/v1/campus/calendar');
    
        // try {
        //     $response = Http::withToken(env('INTERNAL_API_TOKEN'))
        //         ->get($apiUrl, [
        //             'tanggal' => $request->tgl_peminjaman
        //         ]);
                
        //     if ($response->successful()) {
        //         $apiData = $response->json();
                
        //         if (isset($apiData['bisa_pinjam_fasilitas']) && $apiData['bisa_pinjam_fasilitas'] === false) {
        //             return back()->withInput()->withErrors([
        //                 'tgl_peminjaman' => $apiData['keterangan']
        //             ]);
        //         }
        //     }
        // } catch (\Exception $e) {
        //     return back()->withInput()->withErrors(['tgl_peminjaman' => 'Gagal terhubung ke API Kalender Kampus.']);
        // }

        // Cek Status Ruangan (hanya boleh pinjam jika status Tersedia)
        $ruang = Ruang::findOrFail($request->ruang_id);
        if (strtolower($ruang->status) !== 'tersedia') {
            return back()->withErrors(['ruang_id' => 'Ruangan ini sedang dalam perbaikan dan tidak dapat dipinjam.']);
        }

        // Cek Bentrok Jadwal
        $isBentrok = PeminjamanRuang::where('ruang_id', $request->ruang_id)
            ->where('tgl_peminjaman', $request->tgl_peminjaman)
            ->where('status_izin', '!=', 'Ditolak')
            ->where(function ($query) use ($request) {
                $query->where('waktu_mulai', '<', $request->waktu_selesai)
                      ->where('waktu_selesai', '>', $request->waktu_mulai);
            })->exists();

        if ($isBentrok) {
            return back()->withInput()->withErrors(['waktu_mulai' => 'Maaf, ruangan sudah dipesan pada jam tersebut.']);
        }

        PeminjamanRuang::create([
            'user_id' => Auth::id(),
            'status_izin' => 'Pending',
            ...$request->only(['ruang_id', 'nama_acara', 'nama_penyelenggara', 'tgl_peminjaman', 'waktu_mulai', 'waktu_selesai'])
        ]);

        return redirect()->route('mahasiswa.ruang.index')->with('success', 'Pengajuan berhasil!');
    }

    public function historyMahasiswa()
    {
        $history = PeminjamanRuang::with('ruang')->where('user_id', Auth::id())->latest()->get();
        return view('mahasiswa.ruang.history', compact('history'));
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