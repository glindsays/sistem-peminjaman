<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Barang::query();

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('uppk')) {
            $query->where('uppk', $request->uppk);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $barang = $query->paginate(10)->withQueryString();
        $daftarUPPK = \App\Models\Barang::select('uppk')->distinct()->pluck('uppk');

        return view('admin.barang.index', compact('barang', 'daftarUPPK'));
    }

    public function create()
    {
        return view('admin.barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255|unique:barang,nama_barang',
            'jumlah'      => 'required|integer|min:0',
            'status'      => 'required|string|max:50', //misal: 'Tersedia' atau 'Dipinjam'
            'uppk'        => 'required|string|max:255',
        ], [
            'nama_barang.unique' => 'Nama barang sudah digunakan oleh fasilitas lain.',
        ]);

        Barang::create($request->all());

        return redirect()->route('admin.barang.index')->with('success', 'Barang baru berhasil ditambahkan!');
    }

    public function edit(Barang|int $barang)
    {
        $barang = $barang instanceof Barang ? $barang : Barang::findOrFail($barang);
        return view('admin.barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang|int $barang)
    {
        $barang = $barang instanceof Barang ? $barang : Barang::findOrFail($barang);

        $request->validate([
            'nama_barang' => 'required|string|max:255|unique:barang,nama_barang,' . $barang->id,
            'jumlah'      => 'required|integer|min:0',
            'status'      => 'required|string|max:50',
            'uppk'        => 'required|string|max:255',
        ], [
            'nama_barang.unique' => 'Nama barang sudah digunakan oleh fasilitas lain.',
        ]);

        $barang->update($request->all());

        return redirect()->route('admin.barang.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy(Barang|int $barang)
    {
        $barang = $barang instanceof Barang ? $barang : Barang::findOrFail($barang);
        $barang->delete();

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus dari database!');
    }

    public function katalogMahasiswa(Request $request)
    {
        $query = \App\Models\Barang::query();

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $barang = $query->paginate(16)->withQueryString();

        return view('mahasiswa.barang.index', compact('barang'));
    }
}
