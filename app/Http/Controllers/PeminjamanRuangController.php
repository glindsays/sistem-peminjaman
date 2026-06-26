<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanRuang;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::check() && !Auth::user()->is_active) {
            return back()->withErrors(['is_active' => 'Akun Anda sedang dinonaktifkan oleh Admin, Anda tidak dapat mengajukan peminjaman ruang.']);
        }

        $request->validate([
            'ruang_id'           => 'required|exists:ruang,id',
            'nama_acara'         => 'required|string|max:255',
            'nama_penyelenggara' => 'required|string|max:255',
            'tgl_peminjaman'     => 'required|date|after:today',
            'waktu_mulai'        => ['required', 'date_format:H:i', 'regex:/^((0[7-9]|1[0-9]|2[0-1]):(00|30)|22:00)$/'],
            'waktu_selesai'      => ['required', 'date_format:H:i', 'regex:/^((0[7-9]|1[0-9]|2[0-1]):(00|30)|22:00)$/', 'after:waktu_mulai'],
        ], [
            'tgl_peminjaman.after' => 'Tanggal peminjaman minimal harus besok.',
            'waktu_mulai.regex' => 'Peminjaman hanya dapat dilakukan antara pukul 07.00 hingga 22.00 dengan kelipatan 30 menit.',
            'waktu_selesai.regex' => 'Peminjaman hanya dapat dilakukan antara pukul 07.00 hingga 22.00 dengan kelipatan 30 menit.',
            'waktu_mulai.date_format' => 'Format waktu mulai harus berupa jam:menit, misalnya 07:00 atau 07:30.',
            'waktu_selesai.date_format' => 'Format waktu selesai harus berupa jam:menit, misalnya 07:00 atau 07:30.',
            'waktu_selesai.after' => 'Waktu selesai harus lebih besar dari waktu mulai.',
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

        // Cek bentrok jadwal hanya terhadap peminjaman yang sudah disetujui
        $isBentrok = PeminjamanRuang::where('ruang_id', $request->ruang_id)
            ->where('tgl_peminjaman', $request->tgl_peminjaman)
            ->where('status_izin', 'Disetujui')
            ->where(function ($query) use ($request) {
                $query->where('waktu_mulai', '<', $request->waktu_selesai)
                      ->where('waktu_selesai', '>', $request->waktu_mulai);
            })->exists();

        if ($isBentrok) {
            return back()->withInput()->withErrors(['waktu_mulai' => 'Ruangan sudah dipesan pada waktu tersebut.']);
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

        if ($request->status_izin === 'Disetujui') {
            PeminjamanRuang::where('id', '!=', $peminjaman->id)
                ->where('ruang_id', $peminjaman->ruang_id)
                ->where('tgl_peminjaman', $peminjaman->tgl_peminjaman)
                ->where('status_izin', 'Pending')
                ->where(function ($query) use ($peminjaman) {
                    $query->where('waktu_mulai', '<', $peminjaman->waktu_selesai)
                          ->where('waktu_selesai', '>', $peminjaman->waktu_mulai);
                })
                ->update(['status_izin' => 'Ditolak']);
        }

        return redirect()->route('dosen.peminjaman.index')->with('success', "Status pengajuan berhasil diubah menjadi: {$request->status_izin}!");
    }
}