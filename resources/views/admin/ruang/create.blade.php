<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Ruangan Baru</title>
</head>
<body>
    <h1>Form Tambah Ruangan</h1>

    <form action="{{ route('admin.ruang.store') }}" method="POST">
        @csrf

        <p>
            <label>Nama Ruangan:</label><br>
            <input type="text" name="nama_ruangan" required placeholder="Contoh: Auditorium T-501">
        </p>

        <p>
            <label>Kapasitas (Orang):</label><br>
            <input type="number" name="kapasitas" min="1" required placeholder="Contoh: 100">
        </p>

        <p>
            <label>Lokasi / Gedung:</label><br>
            <input type="text" name="lokasi" required placeholder="Contoh: Gedung T Lantai 5">
        </p>

        <p>
            <label>Status Awal:</label><br>
            <select name="status" required>
                <option value="Tersedia">Tersedia</option>
                <option value="Dipakai">Dipakai</option>
                <option value="Perbaikan">Perbaikan</option>
            </select>
        </p>

        <p>
            <label>Unit Pengelola (UPPK):</label><br>
            <input type="text" name="uppk" required placeholder="Contoh: Tata Usaha Gedung T">
        </p>

        <button type="submit" style="background-color: green; color: white; padding: 6px 12px;">Simpan Ruangan</button>
        <a href="{{ route('admin.ruang.index') }}">Batal</a>
    </form>
</body>
</html>