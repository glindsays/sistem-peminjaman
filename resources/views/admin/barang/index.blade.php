<!DOCTYPE html>
<html lang="en">
<head>
    <title>Daftar Barang (BAAK)</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        .alert { background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Manajemen Inventaris Barang</h1>
    
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.barang.create') }}">
        <button type="button" style="background-color: #007bff; color: white; padding: 8px 12px; border:none; cursor:pointer;">+ Tambah Barang Baru</button>
    </a>

    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Stok Jumlah</th>
                <th>Status</th>
                <th>Unit Pengelola (UPPK)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barang as $item)
            <tr>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->jumlah }} pcs</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->uppk }}</td>
                <td>
                    <a href="{{ route('admin.barang.edit', $item->id) }}">
                        <button type="button">Edit</button>
                    </a>

                    <form action="{{ route('admin.barang.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background-color: #ffcccc; color: red;">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #777;">Belum ada data inventaris barang. silakan tambah baru.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>