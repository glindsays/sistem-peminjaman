<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Data Barang</title>
</head>
<body>
    <h1>Ubah Data Barang: {{ $barang->nama_barang }}</h1>

    <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <p>
            <label>Nama Barang:</label><br>
            <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" required>
        </p>

        <p>
            <label>Jumlah Stok:</label><br>
            <input type="number" name="jumlah" value="{{ $barang->jumlah }}" min="0" required>
        </p>

        <p>
            <label>Status Ketersediaan:</label><br>
            <select name="status" required>
                <option value="Tersedia" {{ $barang->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="Tidak Tersedia" {{ $barang->status == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>
        </p>

        <p>
            <label>Unit Pengelola (UPPK):</label><br>
            <input type="text" name="uppk" value="{{ $barang->uppk }}" required>
        </p>

        <button type="submit" style="background-color: #007bff; color: white; padding: 6px 12px;">Simpan Perubahan</button>
        <a href="{{ route('admin.barang.index') }}">Batal</a>
    </form>
</body>
</html>