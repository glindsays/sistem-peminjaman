@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <div>
        <h1 class="text-headline-lg font-bold text-on-surface">Dashboard Mahasiswa</h1>
        <p class="text-body-md text-on-surface-variant mt-1">Selamat datang kembali! Pantau status pengajuan peminjaman fasilitas Anda di sini.</p>
    </div>

    @auth
        @if(!Auth::user()->is_active)
            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-900">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-rose-700">warning</span>
                    <div>
                        <p class="font-semibold">Akun Dinonaktifkan</p>
                        <p class="mt-1">Akun Anda saat ini dinonaktifkan oleh Admin. Anda tidak dapat melakukan peminjaman fasilitas.</p>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        
        <div class="bg-surface-container-lowest border border-border-subtle p-5 rounded-xl shadow-soft flex items-center gap-4">
            <div class="w-12 h-12 bg-primary-fixed text-on-primary-fixed flex items-center justify-center rounded-xl">
                <span class="material-symbols-outlined text-headline-md">assignment</span>
            </div>
            <div>
                <span class="text-label-md text-outline block font-medium uppercase tracking-wider">Total Request</span>
                <span class="text-headline-lg font-bold text-on-surface leading-tight">{{ $totalPeminjaman }}</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest border border-border-subtle p-5 rounded-xl shadow-soft flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-50 text-warning flex items-center justify-center rounded-xl">
                <span class="material-symbols-outlined text-headline-md">pending_actions</span>
            </div>
            <div>
                <span class="text-label-md text-outline block font-medium uppercase tracking-wider">Pending</span>
                <span class="text-headline-lg font-bold text-on-surface leading-tight">{{ $totalPending }}</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest border border-border-subtle p-5 rounded-xl shadow-soft flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 text-success flex items-center justify-center rounded-xl">
                <span class="material-symbols-outlined text-headline-md">check_circle</span>
            </div>
            <div>
                <span class="text-label-md text-outline block font-medium uppercase tracking-wider">Approved</span>
                <span class="text-headline-lg font-bold text-on-surface leading-tight">{{ $totalApproved }}</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest border border-border-subtle p-5 rounded-xl shadow-soft flex items-center gap-4">
            <div class="w-12 h-12 bg-rose-50 text-danger flex items-center justify-center rounded-xl">
                <span class="material-symbols-outlined text-headline-md">cancel</span>
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
                <h3 class="text-title-lg font-bold text-on-surface">Riwayat Pengajuan Terbaru</h3>
            </div>
            <a href="{{ route('mahasiswa.riwayatMahasiswa') }}" class="text-sm bg-surface-container hover:bg-surface-container-high text-primary font-semibold px-4 py-2 rounded-xl transition-colors flex items-center gap-1">
                <span>Lihat Semua</span>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-border-subtle text-label-md text-outline font-bold bg-surface-container-low uppercase tracking-wider">
                        <th class="p-4 w-16 text-center">No</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Nama Fasilitas</th>
                        <th class="p-4">Nama Acara</th>
                        <th class="p-4">Tanggal Pinjam</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-border-subtle text-body-md text-on-surface">
                    @forelse($riwayatGabungan as $index => $riwayat)
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 text-center text-outline font-medium">{{ $index + 1 }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-md {{ $riwayat->tipe == 'Ruangan' ? 'bg-primary-fixed text-primary' : 'bg-secondary-fixed text-secondary' }}">
                                    {{ $riwayat->tipe }}
                                </span>
                            </td>
                            <td class="p-4 font-semibold text-primary">{{ $riwayat->nama_fasilitas }}</td>
                            <td class="p-4 font-medium truncate max-w-[200px]">{{ $riwayat->nama_acara }}</td>
                            <td class="p-4 text-on-surface-variant font-medium">
                                {{ \Carbon\Carbon::parse($riwayat->tgl_peminjaman)->format('d M Y') }}
                            </td>
                            <td class="p-4 text-center">
                                @if($riwayat->status_izin == 'Pending')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold bg-amber-50 text-warning rounded-full border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-warning animate-pulse"></span>
                                        Pending
                                    </span>
                                @elseif($riwayat->status_izin == 'Disetujui')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold bg-emerald-50 text-success rounded-full border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                        Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-danger"></span>
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] text-outline block mb-2">folder_open</span>
                                <span class="text-body-lg font-medium block">Belum ada riwayat pengajuan</span>
                                <span class="text-label-md text-outline mt-1 block">Silakan lakukan peminjaman melalui menu katalog di sidebar.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection