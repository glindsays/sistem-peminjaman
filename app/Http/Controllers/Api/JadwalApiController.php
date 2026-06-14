<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HariLibur;
use Illuminate\Http\Request;

class JadwalApiController extends Controller
{
    public function checkCalendar(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
        ]);

        $tanggalInput = $request->query('tanggal');

        $libur = HariLibur::where('tanggal', $tanggalInput)->first();

        if ($libur) {
            return response()->json([
                'status' => 'success',
                'tanggal' => $tanggalInput,
                'bisa_pinjam_fasilitas' => false,
                'keterangan' => "Hari Libur: " . $libur->keterangan
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'tanggal' => $tanggalInput,
            'bisa_pinjam_fasilitas' => true,
            'keterangan' => 'Hari operasional kampus biasa. Silakan cek ketersediaan jam.'
        ], 200);
    }
}