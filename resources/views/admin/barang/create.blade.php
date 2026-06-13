<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Barang Baru</title>
</head>
<body>
    <h1>Form Tambah Inventaris Barang</h1>

    <form action="{{ route('admin.barang.store') }}" method="POST">
        @csrf

        <p>
            <label>Nama Barang:</label><br>
            <input type="text" name="nama_barang" required placeholder="Contoh: Proyektor Epson X500">
        </p>

        <p>
            <label>Jumlah Stok:</label><br>
            <input type="number" name="jumlah" min="0" required placeholder="Contoh: 10">
        </p>

        <p>
            <label>Status Ketersediaan:</label><br>
            <select name="status" required>
                <option value="Tersedia">Tersedia</option>
                <option value="Tidak Tersedia">Tidak Tersedia</option>
            </select>
        </p>

        <p>
            <label>Unit Pengelola (UPPK):</label><br>
            <input type="text" name="uppk" required placeholder="Contoh: Bidang Fasilitas BAAK">
        </p>

        <button type="submit" style="background-color: green; color: white; padding: 6px 12px;">Simpan Barang</button>
        <a href="{{ route('admin.barang.index') }}">Batal</a>
    </form>
</body>
</html>