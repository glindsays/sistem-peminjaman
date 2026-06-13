<!DOCTYPE html>
<html lang="en">
<head>
    <title>Daftar Ruangan (BAAK)</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        .alert { background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Manajemen Ruangan Kampus</h1>
    
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.ruang.create') }}">
        <button type="button" style="background-color: #007bff; color: white; padding: 8px 12px; border:none; cursor:pointer;">+ Tambah Ruangan Baru</button>
    </a>

    <table>
        <thead>
            <tr>
                <th>Nama Ruangan</th>
                <th>Kapasitas</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Unit Pengelola (UPPK)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ruang as $item)
            <tr>
                <td>{{ $item->nama_ruangan }}</td>
                <td>{{ $item->kapasitas }} Orang</td>
                <td>{{ $item->lokasi }}</td>
                <td><strong>{{ $item->status }}</strong></td>
                <td>{{ $item->uppk }}</td>
                <td>
                    <a href="{{ route('admin.ruang.edit', $item->id) }}">
                        <button type="button">Edit</button>
                    </a>

                    <form action="{{ route('admin.ruang.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background-color: #ffcccc; color: red;">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #777;">Belum ada data ruangan. Silakan tambah baru.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>