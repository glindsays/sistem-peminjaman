<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    public function index()
    {
        $ruang = Ruang::all();
        return view('admin.ruang.index', compact('ruang'));
    }

    public function create()
    {
        return view('admin.ruang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kapasitas'    => 'required|integer|min:1',
            'lokasi'       => 'required|string|max:255',
            'status'       => 'required|string|max:50', // 'Tersedia', 'Dipakai', 'Perbaikan'
            'uppk'         => 'required|string|max:255',
        ]);

        Ruang::create($request->all());

        return redirect()->route('admin.ruang.index')->with('success', 'Ruangan baru berhasil didaftarkan!');
    }

    public function edit(Ruang|int $ruang)
    {
        $ruang = $ruang instanceof Ruang ? $ruang : Ruang::findOrFail($ruang);
        return view('admin.ruang.edit', compact('ruang'));
    }

    public function update(Request $request, Ruang|int $ruang)
    {
        $ruang = $ruang instanceof Ruang ? $ruang : Ruang::findOrFail($ruang);

        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kapasitas'    => 'required|integer|min:1',
            'lokasi'       => 'required|string|max:255',
            'status'       => 'required|string|max:50',
            'uppk'         => 'required|string|max:255',
        ]);

        $ruang->update($request->all());

        return redirect()->route('admin.ruang.index')->with('success', 'Data ruangan berhasil diperbarui!');
    }

    public function destroy(Ruang|int $ruang)
    {
        $ruang = $ruang instanceof Ruang ? $ruang : Ruang::findOrFail($ruang);
        $ruang->delete();

        return redirect()->route('admin.ruang.index')->with('success', 'Ruangan berhasil dihapus dari sistem!');
    }
}
