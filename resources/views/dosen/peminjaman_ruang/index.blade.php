<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Persetujuan Dosen & BAAK</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        tr:hover { background-color: #f9f9f9; }
        
        /* Gaya Status Badge */
        .badge { padding: 5px 10px; border-radius: 4px; font-weight: bold; font-size: 13px; }
        .pending { background-color: #fef3c7; color: #856404; }
        .approved { background-color: #d1fae5; color: #065f46; }
        .rejected { background-color: #fee2e2; color: #991b1b; }
        
        /* Gaya Tombol */
        .btn { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-approve { background-color: #10b981; color: white; margin-right: 5px; }
        .btn-approve:hover { background-color: #059669; }
        .btn-reject { background-color: #ef4444; color: white; }
        .btn-reject:hover { background-color: #dc2626; }
        
        .alert-success { background-color: #d1fae5; color: #065f46; padding: 15px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #a7f3d0; }
        .info-user { background-color: #f3f4f6; padding: 10px; margin-bottom: 20px; border-left: 5px solid #3b82f6; }
    </style>
</head>
<body>

    <h1>Panel Review Pengajuan Peminjaman Ruangan</h1>
    
    <div class="info-user">
        Status Login: <strong>{{ auth()->user()->name }}</strong> 
        (Role: <span style="text-transform: uppercase; color: #3b82f6;">{{ auth()->user()->role->nama_role }}</span>)
    </div>

    @if(session('success'))
        <div class="alert-success">
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nama Mahasiswa</th>
                <th>Ruangan</th>
                <th>Nama Kegiatan / Ormawa</th>
                <th>Tanggal Pinjam</th>
                <th>Waktu Sesi</th>
                <th>Status Izin</th>
                <th>Tindakan / Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuan as $p)
            <tr>
                <td>
                    <strong>{{ $p->user->name }}</strong><br>
                    <small style="color: #666;">{{ $p->user->email }}</small>
                </td>
                
                <td>{{ $p->ruang->nama_ruangan }} <br><small style="color:#777;">{{ $p->ruang->lokasi }}</small></td>
                
                <td>
                    <u>{{ $p->nama_acara }}</u><br>
                    <small>Penyelenggara: <strong>{{ $p->nama_penyelenggara }}</strong></small>
                </td>
                <td>{{ date('d M Y', strtotime($p->tgl_peminjaman)) }}</td>
                <td>{{ $p->waktu_mulai }} - {{ $p->waktu_selesai }} WIB</td>
                <td>
                    @if($p->status_izin == 'Pending')
                        <span class="badge pending">⏳ Pending</span>
                    @elseif($p->status_izin == 'Disetujui')
                        <span class="badge approved">✓ Disetujui</span>
                    @else
                        <span class="badge rejected">✗ Ditolak</span>
                    @endif
                </td>
                <td>
                    @if($p->status_izin == 'Pending')
                        <form action="{{ route('dosen.peminjaman.updateStatus', $p->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status_izin" value="Disetujui">
                            <button type="submit" class="btn btn-approve" onclick="return confirm('Setujui permohonan peminjaman ruang ini?')">Approve</button>
                        </form>

                        <form action="{{ route('dosen.peminjaman.updateStatus', $p->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status_izin" value="Ditolak">
                            <button type="submit" class="btn btn-reject" onclick="return confirm('Tolak permohonan peminjaman ruang ini?')">Reject</button>
                        </form>
                    @else
                        <span style="color: #999; font-style: italic; font-size: 13px;">Keputusan Final</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #777; padding: 20px;">Belum ada berkas pengajuan masuk dari mahasiswa.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>