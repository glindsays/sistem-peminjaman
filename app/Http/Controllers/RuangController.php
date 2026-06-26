<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RuangController extends Controller
{
    public function __construct() {
        // Menggunakan 'uppk' sebagai zonasi gedung sesuai kode view kamu
        view()->share('daftarGedung', Ruang::select('uppk')->distinct()->pluck('uppk'));
    }

    public function index(Request $request)
    {
        $query = Ruang::query();
        
        // Filter pencarian dan gedung
        if ($request->filled('search')) $query->where('nama_ruangan', 'like', '%' . $request->search . '%');
        if ($request->filled('lokasi')) $query->where('uppk', $request->lokasi);
        
        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = Auth::user()->role_id == 1 ? 10 : 16;
        $ruang = $query->paginate($perPage)->withQueryString();

        // Jika user adalah admin, arahkan ke view admin
        if (Auth::user()->role_id == 1) {
            return view('admin.ruang.index', compact('ruang'));
        }

        // Jika mahasiswa, arahkan ke katalog mahasiswa
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