<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use App\Models\Barang;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $kategori = $request->kategori;

        $ruangan = collect();
        $barang = collect();

        // Ambil data ruangan
        if (!$kategori || $kategori == 'semua' || $kategori == 'ruang') {
            $ruangan = Ruang::when($keyword, fn($q) => $q->where('nama_ruangan', 'like', "%$keyword%"))
                ->get()->map(fn($item) => (object)[
                    'nama' => $item->nama_ruangan,
                    'kategori' => 'ruang',
                    'lokasi' => $item->lokasi,
                    'jumlah_kapasitas' => $item->kapasitas . ' Orang',
                    'status' => $item->status,
                ]);
        }

        // Ambil data barang
        if (!$kategori || $kategori == 'semua' || $kategori == 'barang') {
            $barang = Barang::when($keyword, fn($q) => $q->where('nama_barang', 'like', "%$keyword%"))
                ->get()->map(fn($item) => (object)[
                    'nama' => $item->nama_barang,
                    'kategori' => 'barang',
                    'lokasi' => $item->uppk,
                    'jumlah_kapasitas' => $item->jumlah . ' Unit',
                    'status' => $item->status,
                ]);
        }

        // Gabungkan data agar tampil di satu grid
        $fasilitas = $ruangan->merge($barang);

        return view('landing', compact('fasilitas'));
    }
}