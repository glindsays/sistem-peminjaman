@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 rounded-xl bg-surface-container hover:bg-surface-container-high flex items-center justify-center text-primary transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-headline-lg font-bold text-on-surface">Log Antrean & Riwayat Validasi</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Daftar menyeluruh dari semua riwayat pengajuan peminjaman fasilitas.</p>
        </div>
    </div>

    <div class="flex border-b border-outline-variant gap-2">
        <a href="?tab=ruang" class="px-5 py-3 text-body-md font-semibold border-b-2 transition-all {{ request('tab') == 'ruang' || !request('tab') ? 'border-primary text-primary' : 'border-transparent text-outline hover:text-on-surface' }}">
            Riwayat Ruangan
        </a>
        <a href="?tab=barang" class="px-5 py-3 text-body-md font-semibold border-b-2 transition-all {{ request('tab') == 'barang' ? 'border-primary text-primary' : 'border-transparent text-outline hover:text-on-surface' }}">
            Riwayat Barang
        </a>
    </div>

    <div class="bg-surface-container-lowest border border-border-subtle rounded-2xl shadow-soft overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-surface-container-low text-label-md text-outline uppercase tracking-wider border-b border-border-subtle">
                    <tr>
                        <th class="p-4 text-center">No</th>
                        <th class="p-4">Peminjam</th>
                        <th class="p-4">{{ request('tab') == 'barang' ? 'Nama Barang' : 'Nama Ruangan' }}</th>
                        <th class="p-4">Acara</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-border-subtle text-body-md text-on-surface">
                    @php $data = (request('tab') == 'barang') ? $riwayatBarang : $riwayatRuang; @endphp
                    @forelse($data as $index => $item)
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 text-center text-outline font-medium">{{ $data->firstItem() + $index }}</td>
                            <td class="p-4">
                                <div class="font-semibold">{{ $item->user->name ?? 'N/A' }}</div>
                                <div class="text-xs text-outline">{{ $item->user->email ?? '' }}</div>
                            </td>
                            <td class="p-4 font-bold text-primary">{{ request('tab') == 'barang' ? ($item->barang->nama_barang ?? 'N/A') : ($item->ruang->nama_ruangan ?? 'N/A') }}</td>
                            <td class="p-4">
                                <div class="font-medium">{{ $item->nama_acara }}</div>
                                <div class="text-label-md text-outline">{{ $item->nama_penyelenggara }}</div>
                            </td>
                            <td class="p-4 text-on-surface-variant font-medium">
                                {{ \Carbon\Carbon::parse($item->tgl_peminjaman)->format('d M Y') }}
                            </td>
                            <td class="p-4 text-center">
                                @if($item->status_izin == 'Pending')
                                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full border bg-amber-50 text-warning border-amber-200">Pending</span>
                                @elseif($item->status_izin == 'Disetujui' || $item->status_izin == 'Approved')
                                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full border bg-emerald-50 text-success border-emerald-200">Approved</span>
                                @else
                                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full border bg-rose-50 text-danger border-rose-200">Rejected</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-on-surface-variant">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-border-subtle bg-surface-muted">
            {{ $data->links() }}
        </div>
    </div>
</div>
@endsection