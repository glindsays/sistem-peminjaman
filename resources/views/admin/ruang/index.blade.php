@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-headline-lg font-bold text-on-surface">Manajemen Ruangan</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Kelola data ruangan kampus yang dapat dipinjam.</p>
        </div>
        <a href="{{ route('admin.ruang.create') }}" 
           class="inline-flex items-center gap-2 bg-primary text-white px-5 py-3 rounded-xl text-body-md font-bold shadow-sm hover:brightness-110 active:scale-[0.98] transition-all shrink-0 justify-center">
            <span class="material-symbols-outlined text-body-lg">add</span>
            <span>Tambah Ruang Baru</span>
        </a>
    </div>

    <div class="bg-surface-container-lowest border border-border-subtle p-4 rounded-xl shadow-soft">
        <form action="{{ route('admin.ruang.index') }}" method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <div class="space-y-1.5">
                <label class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Cari Ruangan</label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama ruangan..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low border border-border-subtle rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Zonasi Gedung</label>
                <div class="relative">
                    <select name="lokasi" onchange="document.getElementById('filterForm').submit()" 
                            class="w-full px-4 py-2.5 bg-surface-container-low border border-border-subtle rounded-lg text-body-md appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">-- Semua Gedung --</option>
                        @foreach($daftarGedung as $gedung)
                            <option value="{{ $gedung }}" {{ request('lokasi') == $gedung ? 'selected' : '' }}>{{ $gedung }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Status Operasional</label>
                <div class="relative">
                    <select name="status" onchange="document.getElementById('filterForm').submit()" 
                            class="w-full px-4 py-2.5 bg-surface-container-low border border-border-subtle rounded-lg text-body-md appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">-- Semua Status --</option>
                        <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Dipakai" {{ request('status') == 'Dipakai' ? 'selected' : '' }}>Dipakai</option>
                        <option value="Perbaikan" {{ request('status') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
        @forelse($ruang as $item)
            @php $status = strtolower($item->status); @endphp
            <div class="bg-surface-container-lowest border border-border-subtle rounded-2xl p-5 shadow-soft flex flex-col justify-between hover:border-primary-fixed-dim hover:shadow-md transition-all">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-primary-low text-primary flex items-center justify-center mb-1">
                        <span class="material-symbols-outlined text-headline-md">meeting_room</span>
                    </div>
                    
                    <h3 class="text-title-lg font-bold text-on-surface mb-1">{{ $item->nama_ruangan }}</h3>
                    <p class="text-label-md text-outline font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">corporate_fare</span> <span>UPPK {{ $item->uppk }}</span>
                    </p>

                    <div class="grid grid-cols-2 gap-2 mt-4 text-body-md text-on-surface-variant">
                        <div>
                            <span class="text-label-md text-outline block uppercase tracking-wider">Kapasitas</span>
                            <span class="font-semibold text-on-surface">{{ $item->kapasitas }} Orang</span>
                        </div>
                        <div>
                            <span class="text-label-md text-outline block uppercase tracking-wider">Lokasi</span>
                            <span class="font-semibold text-on-surface truncate block">{{ $item->lokasi }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-border-subtle flex items-center justify-between">
                    @if(strtolower($item->status) == 'tersedia')
                        <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-50 text-success rounded-full border border-emerald-200 uppercase">Tersedia</span>
                    @else
                        <span class="px-2 py-0.5 text-[10px] font-bold bg-rose-50 text-warning rounded-full border border-rose-200 uppercase">Perbaikan</span>
                    @endif
                    
                    <a href="{{ route('admin.ruang.edit', $item->id) }}" class="text-primary font-bold text-xs hover:underline">Edit</a>
                </div>
            </div>
        @empty
            <div class="col-span-full p-12 text-center text-on-surface-variant">Data tidak ditemukan.</div>
        @endforelse
    </div>
</div>
@endsection