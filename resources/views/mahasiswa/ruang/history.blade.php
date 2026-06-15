<!DOCTYPE html>
<html lang="en">
<head>
    <title>Riwayat Peminjaman Ruang</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .alert-success { background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; }
        .badge-pending { color: #856404; background-color: #fff3cd; padding: 3px 8px; border-radius: 5px; }
        .badge-approved { color: #155724; background-color: #d4edda; padding: 3px 8px; border-radius: 5px; }
        .badge-rejected { color: #721c24; background-color: #f8d7da; padding: 3px 8px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Riwayat Pengajuan Peminjaman Ruang Saya</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('mahasiswa.peminjaman.create') }}">
        <button style="padding: 8px 12px; cursor: pointer;">+ Buat Pengajuan Baru</button>
    </a>
    <br><br>

    <table>
        <thead>
            <tr>
                <th>Ruangan</th>
                <th>Nama Acara</th>
                <th>Tanggal</th>
                <th>Waktu Durasi</th>
                <th>Status Persetujuan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($history as $r)
            <tr>
                <td>{{ $r->ruang->nama_ruangan }}</td>
                <td>{{ $r->nama_acara }} <br> <small>Oleh: {{ $r->nama_penyelenggara }}</small></td>
                <td>{{ $r->tgl_peminjaman }}</td>
                <td>{{ $r->waktu_mulai }} - {{ $r->waktu_selesai }}</td>
                <td>
                    @if($r->status_izin == 'Pending')
                        <span class="badge-pending">⏳ Menunggu Review</span>
                    @elseif($r->status_izin == 'Disetujui')
                        <span class="badge-approved">✓ Disetujui Dosen</span>
                    @else
                        <span class="badge-rejected">✗ Ditolak</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #777;">Kamu belum pernah mengirim pengajuan peminjaman ruangan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>