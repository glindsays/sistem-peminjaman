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

        if (!$kategori || $kategori == 'semua' || $kategori == 'ruang') {
            $ruangan = Ruang::when($keyword, fn($q) => $q->where('nama_ruangan', 'like', "%$keyword%"))
                ->get()->map(fn($item) => (object)[
                    'nama' => $item->nama_ruangan,
                    'kategori' => 'ruang',
                    'lokasi' => $item->lokasi,
                    'uppk' => null,
                    'jumlah_kapasitas' => $item->kapasitas . ' Orang',
                    'status' => $item->status,
                ]);
        }

        if (!$kategori || $kategori == 'semua' || $kategori == 'barang') {
            $barang = Barang::when($keyword, fn($q) => $q->where('nama_barang', 'like', "%$keyword%"))
                ->get()->map(fn($item) => (object)[
                    'nama' => $item->nama_barang,
                    'kategori' => 'barang',
                    'lokasi' => $item->uppk,
                    'uppk' => $item->uppk,
                    'jumlah_kapasitas' => $item->jumlah . ' Unit',
                    'status' => $item->status,
                ]);
        }

        $fasilitas = $ruangan->concat($barang);
        return view('landing', compact('fasilitas'));
    }
}