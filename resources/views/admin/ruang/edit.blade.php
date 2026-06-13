<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Data Ruangan</title>
</head>
<body>
    <h1>Ubah Ruangan: {{ $ruang->nama_ruangan }}</h1>

    <form action="{{ route('admin.ruang.update', $ruang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <p>
            <label>Nama Ruangan:</label><br>
            <input type="text" name="nama_ruangan" value="{{ $ruang->nama_ruangan }}" required>
        </p>

        <p>
            <label>Kapasitas:</label><br>
            <input type="number" name="kapasitas" value="{{ $ruang->kapasitas }}" min="1" required>
        </p>

        <p>
            <label>Lokasi / Gedung:</label><br>
            <input type="text" name="lokasi" value="{{ $ruang->lokasi }}" required>
        </p>

        <p>
            <label>Status Ruangan:</label><br>
            <select name="status" required>
                <option value="Tersedia" {{ $ruang->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="Dipakai" {{ $ruang->status == 'Dipakai' ? 'selected' : '' }}>Dipakai</option>
                <option value="Perbaikan" {{ $ruang->status == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
            </select>
        </p>

        <p>
            <label>Unit Pengelola (UPPK):</label><br>
            <input type="text" name="uppk" value="{{ $ruang->uppk }}" required>
        </p>

        <button type="submit" style="background-color: #007bff; color: white; padding: 6px 12px;">Simpan Perubahan</button>
        <a href="{{ route('admin.ruang.index') }}">Batal</a>
    </form>
</body>
</html>