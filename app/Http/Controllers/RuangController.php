<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RuangController extends Controller
{
    public function __construct() {
        view()->share('daftarGedung', Ruang::select('uppk')->distinct()->pluck('uppk'));
    }

    public function index(Request $request)
    {
        $query = Ruang::query();
        
        if ($request->filled('search')) $query->where('nama_ruangan', 'like', '%' . $request->search . '%');
        if ($request->filled('lokasi')) $query->where('uppk', $request->lokasi);
        
        if ($request->filled('status')) {
            $query->whereRaw('LOWER(status) = ?', [strtolower(trim($request->status))]);
        }

        $perPage = Auth::check() && Auth::user()->role_id == 1 ? 10 : 16;
        $ruang = $query->paginate($perPage)->withQueryString();

        if (Auth::check() && Auth::user()->role_id == 1) {
            return view('admin.ruang.index', compact('ruang'));
        }

        return view('mahasiswa.ruang.index', compact('ruang'));
    }

    public function create()
    {
        return view('admin.ruang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruang,nama_ruangan',
            'kapasitas'    => 'required|integer|min:1',
            'lokasi'       => 'required|string|max:255',
            'status'       => 'required|string|max:50',
            'uppk'         => 'required|string|max:255',
        ], [
            'nama_ruangan.unique' => 'Nama ruangan sudah digunakan oleh fasilitas lain.',
        ]);

        Ruang::create($request->all());

        return redirect()->route('admin.ruang.index')->with('success', 'Ruangan baru berhasil didaftarkan!');
    }

    public function edit(Ruang $ruang)
    {
        return view('admin.ruang.edit', compact('ruang'));
    }

    public function update(Request $request, Ruang $ruang)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruang,nama_ruangan,' . $ruang->id,
            'kapasitas'    => 'required|integer|min:1',
            'lokasi'       => 'required|string|max:255',
            'status'       => 'required|string|max:50',
            'uppk'         => 'required|string|max:255',
        ], [
            'nama_ruangan.unique' => 'Nama ruangan sudah digunakan oleh fasilitas lain.',
        ]);

        $ruang->update($request->all());

        return redirect()->route('admin.ruang.index')->with('success', 'Data ruangan berhasil diperbarui!');
    }

    public function destroy(Ruang $ruang)
    {
        $ruang->delete();
        return redirect()->route('admin.ruang.index')->with('success', 'Ruangan berhasil dihapus!');
    }
}