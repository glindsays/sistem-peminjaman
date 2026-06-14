<!DOCTYPE html>
<html lang="en">
<head>
    <title>Form Pengajuan Peminjaman Ruang</title>
    <style>
        .error-box { background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border: 1px solid #f5c6cb; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { background-color: #007bff; color: white; padding: 10px 15px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Pengajuan Peminjaman Ruangan Kampus</h1>
    <a href="{{ route('mahasiswa.peminjaman.history') }}">← Lihat Riwayat Saya</a>
    <br><br>

    @if($errors->any())
        <div class="error-box">
            <strong>Terjadi Kesalahan Pengajuan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mahasiswa.peminjaman.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="ruang_id">Pilih Ruangan:</label>
            <select name="ruang_id" id="ruang_id" required>
                <option value="">-- Pilih Ruangan yang Tersedia --</option>
                @foreach($ruangan as $r)
                    <option value="{{ $r->id }}" {{ old('ruang_id') == $r->id ? 'selected' : '' }}>
                        {{ $r->nama_ruangan }} (Kapasitas: {{ $r->kapasitas }} orang - {{ $r->lokasi }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nama_acara">Nama Kegiatan / Acara:</label>
            <input type="text" name="nama_acara" id="nama_acara" value="{{ old('nama_acara') }}" required placeholder="Contoh: Rapat Koordinasi Anggota Ormawa">
        </div>

        <div class="form-group">
            <label for="nama_penyelenggara">Nama Organisasi / Penyelenggara:</label>
            <input type="text" name="nama_penyelenggara" id="nama_penyelenggara" value="{{ old('nama_penyelenggara') }}" required placeholder="Contoh: BEM FIK">
        </div>

        <div class="form-group">
            <label for="tgl_peminjaman">Tanggal Kegiatan:</label>
            <input type="date" name="tgl_peminjaman" id="tgl_peminjaman" value="{{ old('tgl_peminjaman') }}" required min="{{ date('Y-m-d') }}">
        </div>

        <div class="form-group">
            <label for="waktu_mulai">Waktu Mulai Acara (07:00 - 22:00):</label>
            <input type="time" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai') }}" required min="07:00" max="22:00">
        </div>

        <div class="form-group">
            <label for="waktu_selesai">Waktu Selesai Acara (Maks jam 22:00):</label>
            <input type="time" name="waktu_selesai" id="waktu_selesai" value="{{ old('waktu_selesai') }}" required min="07:00" max="22:00">
        </div>

        <button type="submit">Kirim Formulir Pengajuan</button>
    </form>
</body>
</html>