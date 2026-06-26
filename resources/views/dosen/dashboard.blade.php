@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <div>
        <h1 class="text-headline-lg font-bold text-on-surface">Overview Dashboard Dosen</h1>
        <p class="text-body-md text-on-surface-variant mt-1">Selamat datang, Dosen Pembina. Periksa dan berikan validasi persetujuan izin peminjaman di bawah ini.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        
        <div class="bg-surface-container-lowest border border-border-subtle p-5 rounded-xl shadow-soft flex items-center gap-4">
            <div class="w-12 h-12 bg-primary-fixed text-on-primary-fixed flex items-center justify-center rounded-xl">
                <span class="material-symbols-outlined text-headline-md">inbox</span>
            </div>
            <div>
                <span class="text-label-md text-outline block font-medium uppercase tracking-wider">Total</span>
                <span class="text-headline-lg font-bold text-on-surface leading-tight">{{ $totalPengajuan }}</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest border border-border-subtle p-5 rounded-xl shadow-soft flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-50 text-warning flex items-center justify-center rounded-xl">
                <span class="material-symbols-outlined text-headline-md">gavel</span>
            </div>
            <div>
                <span class="text-label-md text-outline block font-medium uppercase tracking-wider">Pending</span>
                <span class="text-headline-lg font-bold text-on-surface leading-tight text-warning">{{ $totalPending }}</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest border border-border-subtle p-5 rounded-xl shadow-soft flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 text-success flex items-center justify-center rounded-xl">
                <span class="material-symbols-outlined text-headline-md">verified</span>
            </div>
            <div>
                <span class="text-label-md text-outline block font-medium uppercase tracking-wider">Approved</span>
                <span class="text-headline-lg font-bold text-on-surface leading-tight">{{ $totalApproved }}</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest border border-border-subtle p-5 rounded-xl shadow-soft flex items-center gap-4">
            <div class="w-12 h-12 bg-rose-50 text-danger flex items-center justify-center rounded-xl">
                <span class="material-symbols-outlined text-headline-md">block</span>
            </div>
            <div>
                <span class="text-label-md text-outline block font-medium uppercase tracking-wider">Rejected</span>
                <span class="text-headline-lg font-bold text-on-surface leading-tight">{{ $totalRejected }}</span>
            </div>
        </div>

    </div>

    <div class="bg-surface-container-lowest border border-border-subtle rounded-xl shadow-soft overflow-hidden">
        <div class="p-gutter border-b border-border-subtle flex justify-between items-center bg-surface-muted">
            <div>
                <h3 class="text-title-lg font-bold text-on-surface">Antrean Validasi Peminjaman</h3>
            </div>
            <a href="{{ route('dosen.riwayat') }}" class="text-sm bg-surface-container hover:bg-surface-container-high text-primary font-semibold px-4 py-2 rounded-xl transition-colors flex items-center gap-1">
                <span>Lihat Semua</span>
                <span class="material-symbols-outlined text-[16px]">page_control</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-[720px] w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-border-subtle text-label-md text-outline font-bold bg-surface-container-low uppercase tracking-wider">
                        <th class="p-4 w-12 text-center">No</th>
                        <th class="p-4">Peminjam</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Fasilitas</th>
                        <th class="p-4">Acara & Penyelenggara</th>
                        <th class="p-4">Waktu Sesi</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-border-subtle text-body-md text-on-surface">
                    @forelse($antreanMasuk as $antrean)
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 text-center text-outline font-medium">{{ $loop->iteration }}</td>
                            
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-on-surface">{{ $antrean->user->name ?? 'Unknown Student' }}</span>
                                </div>
                            </td>

                            <td class="p-4">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-md {{ $antrean->tipe == 'Ruangan' ? 'bg-primary-fixed text-primary' : 'bg-secondary-fixed text-secondary' }}">
                                    {{ $antrean->tipe }}
                                </span>
                            </td>

                            <td class="p-4 font-semibold text-primary">
                                {{ $antrean->nama_fasilitas }}
                                @if($antrean->tipe == 'Barang')
                                    <span class="text-xs text-outline font-normal block mt-0.5">Jumlah: {{ $antrean->jumlah_barang }} pcs</span>
                                @endif
                            </td>

                            <td class="p-4">
                                <div class="flex flex-col truncate max-w-[220px]">
                                    <span class="font-medium text-on-surface truncate">{{ $antrean->nama_acara }}</span>
                                    <span class="text-label-md text-outline truncate mt-0.5">{{ $antrean->nama_penyelenggara }}</span>
                                </div>
                            </td>

                            <td class="p-4 font-medium text-on-surface-variant">
                                <div>{{ \Carbon\Carbon::parse($antrean->tgl_peminjaman)->format('d M Y') }}</div>
                                <div class="text-label-md text-outline font-normal mt-0.5">
                                    {{ substr($antrean->waktu_mulai, 0, 5) }} - {{ substr($antrean->waktu_selesai, 0, 5) }}
                                </div>
                            </td>

                            <td class="p-4 text-center">
                                @if($antrean->status_izin == 'Pending')
                                    <span class="inline-block px-2.5 py-1 text-xs font-bold bg-amber-50 text-warning rounded-full border border-amber-200">Pending</span>
                                @elseif($antrean->status_izin == 'Disetujui')
                                    <span class="inline-block px-2.5 py-1 text-xs font-bold bg-emerald-50 text-success rounded-full border border-emerald-200">Disetujui</span>
                                @else
                                    <span class="inline-block px-2.5 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] text-outline block mb-2">done_all</span>
                                <span class="text-body-lg font-medium block">Semua antrean bersih!</span>
                                <span class="text-label-md text-outline mt-1 block">Saat ini tidak ada pengajuan baru dari mahasiswa yang perlu divalidasi.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection