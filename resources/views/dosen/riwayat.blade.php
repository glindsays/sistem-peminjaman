@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center gap-4">
        <a href="{{ route('dosen.dashboard') }}" class="w-10 h-10 rounded-xl bg-surface-container hover:bg-surface-container-high flex items-center justify-center text-primary transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-headline-lg font-bold text-on-surface">Log Antrean & Riwayat Validasi</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Daftar menyeluruh dari semua berkas dokumen pengajuan peminjaman fasilitas oleh mahasiswa.</p>
        </div>
    </div>

    <div class="flex border-b border-outline-variant gap-2">
        <a href="?tab=ruang" class="px-5 py-3 text-body-md font-semibold border-b-2 transition-all duration-150 {{ $tabAktif === 'ruang' ? 'border-primary text-primary' : 'border-transparent text-outline hover:text-on-surface' }}">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-body-lg">meeting_room</span>
                <span>Antrean Ruangan</span>
            </div>
        </a>
        <a href="?tab=barang" class="px-5 py-3 text-body-md font-semibold border-b-2 transition-all duration-150 {{ $tabAktif === 'barang' ? 'border-primary text-primary' : 'border-transparent text-outline hover:text-on-surface' }}">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-body-lg">inventory_2</span>
                <span>Antrean Barang</span>
            </div>
        </a>
    </div>

    <div class="bg-surface-container-lowest border border-border-subtle rounded-xl shadow-soft overflow-hidden">

        @if($tabAktif === 'ruang')
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-border-subtle text-label-md text-outline font-bold bg-surface-container-low uppercase tracking-wider">
                        <th class="p-4 w-16 text-center">No</th>
                        <th class="p-4">Pemohon</th>
                        <th class="p-4">Nama Ruangan</th>
                        <th class="p-4">Nama Acara / Ormawa</th>
                        <th class="p-4">Waktu Peminjaman</th>
                        <th class="p-4">Waktu Selesai</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-border-subtle text-body-md text-on-surface">
                    @forelse($riwayatRuang as $index => $ruang)
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 text-center text-outline font-medium">
                                {{ $riwayatRuang->firstItem() + $index }}
                            </td>
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="font-semibold">{{ $ruang->user->name ?? 'N/A' }}</span>
                                    <span class="text-xs text-outline mt-0.5">{{ $ruang->user->email ?? '' }}</span>
                                </div>
                            </td>
                            <td class="p-4 font-bold text-primary">{{ $ruang->ruang->nama_ruangan ?? 'N/A' }}</td>
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="font-medium text-on-surface">{{ $ruang->nama_acara }}</span>
                                    <span class="text-label-md text-outline mt-0.5">{{ $ruang->nama_penyelenggara }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-on-surface-variant font-medium whitespace-nowrap">
                                <div>{{ \Carbon\Carbon::parse($ruang->tgl_peminjaman)->format('d M Y') }}</div>
                                <div class="text-label-md text-outline font-normal mt-0.5">{{ substr($ruang->waktu_mulai, 0, 5) }}</div>
                            </td>
                            <td class="p-4 text-on-surface-variant font-medium whitespace-nowrap">
                                <div>{{ \Carbon\Carbon::parse($ruang->tgl_peminjaman)->format('d M Y') }}</div>
                                <div class="text-label-md text-outline font-normal mt-0.5">{{ substr($ruang->waktu_selesai, 0, 5) }}</div>
                            </td>
                            <td class="p-4 text-center">
                                @if($ruang->status_izin == 'Pending')
                                    <span class="inline-block px-2.5 py-1 text-xs font-bold bg-amber-50 text-warning rounded-full border border-amber-200">Pending</span>
                                @elseif($ruang->status_izin == 'Disetujui')
                                    <span class="inline-block px-2.5 py-1 text-xs font-bold bg-emerald-50 text-success rounded-full border border-emerald-200">Disetujui</span>
                                @else
                                    <span class="inline-block px-2.5 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-on-surface-variant">Belum ada data pengajuan peminjaman ruangan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-border-subtle bg-surface-muted">
            {{ $riwayatRuang->links() }}
        </div>

        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-border-subtle text-label-md text-outline font-bold bg-surface-container-low uppercase tracking-wider">
                        <th class="p-4 w-16 text-center">No</th>
                        <th class="p-4">Pemohon</th>
                        <th class="p-4">Nama Barang</th>
                        <th class="p-4 text-center">Jumlah</th>
                        <th class="p-4">Nama Acara / Ormawa</th>
                        <th class="p-4">Waktu Peminjaman</th>
                        <th class="p-4">Waktu Pengembalian</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-border-subtle text-body-md text-on-surface">
                    @forelse($riwayatBarang as $index => $barang)
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 text-center text-outline font-medium">
                                {{ $riwayatBarang->firstItem() + $index }}
                            </td>
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="font-semibold">{{ $barang->user->name ?? 'N/A' }}</span>
                                    <span class="text-xs text-outline mt-0.5">{{ $barang->user->email ?? '' }}</span>
                                </div>
                            </td>
                            <td class="p-4 font-bold text-secondary">{{ $barang->barang->nama_barang ?? 'N/A' }}</td>
                            <td class="p-4 text-center font-semibold bg-surface-container-low/50">{{ $barang->jumlah_barang }} pcs</td>
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="font-medium text-on-surface">{{ $barang->nama_acara }}</span>
                                    <span class="text-label-md text-outline mt-0.5">{{ $barang->nama_penyelenggara }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-on-surface-variant font-medium whitespace-nowrap">
                                <div>{{ \Carbon\Carbon::parse($barang->tgl_peminjaman)->format('d M Y') }}</div>
                                <div class="text-label-md text-outline font-normal mt-0.5">{{ substr($barang->waktu_mulai, 0, 5) }}</div>
                            </td>
                            <td class="p-4 text-on-surface-variant font-medium whitespace-nowrap">
                                <div>{{ \Carbon\Carbon::parse($barang->tgl_pengembalian)->format('d M Y') }}</div>
                                <div class="text-label-md text-outline font-normal mt-0.5">{{ substr($barang->waktu_selesai, 0, 5) }}</div>
                            </td>
                            <td class="p-4 text-center">
                                @if($barang->status_izin == 'Pending')
                                    <span class="inline-block px-2.5 py-1 text-xs font-bold bg-amber-50 text-warning rounded-full border border-amber-200">Pending</span>
                                @elseif($barang->status_izin == 'Disetujui')
                                    <span class="inline-block px-2.5 py-1 text-xs font-bold bg-emerald-50 text-success rounded-full border border-emerald-200">Disetujui</span>
                                @else
                                    <span class="inline-block px-2.5 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-on-surface-variant">Belum ada data pengajuan peminjaman barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-border-subtle bg-surface-muted">
            {{ $riwayatBarang->links() }}
        </div>
        @endif

    </div>
</div>

<div id="app-data" data-success="{{ session('success') }}" data-error="{{ session('error') }}" class="hidden"></div>

@endsection
