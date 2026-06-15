@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <div>
        <h1 class="text-headline-lg font-bold text-on-surface">Katalog Ruangan Kampus</h1>
        <p class="text-body-md text-on-surface-variant mt-1">Cari ruang kelas, aula, atau laboratorium yang tersedia untuk mendukung kegiatan acara Anda.</p>
    </div>

    <div class="bg-surface-container-lowest border border-border-subtle p-4 rounded-xl shadow-soft">
        <form action="{{ route('mahasiswa.ruang.index') }}" method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
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
                            class="w-full px-4 py-2.5 bg-surface-container-low border border-border-subtle rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer appearance-none">
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
                            class="w-full px-4 py-2.5 bg-surface-container-low border border-border-subtle rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer appearance-none">
                        <option value="">-- Semua Status --</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia (Bisa Dipinjam)</option>
                        <option value="dipakai" {{ request('status') == 'dipakai' ? 'selected' : '' }}>Sedang Dipakai</option>
                        <option value="perbaikan" {{ request('status') == 'perbaikan' ? 'selected' : '' }}>Perbaikan (Maintenance)</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                </div>
            </div>

        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
        @forelse($ruang as $item)
            <div class="bg-surface-container-lowest border border-border-subtle rounded-2xl p-5 shadow-soft flex flex-col justify-between hover:border-primary-fixed-dim hover:shadow-md transition-all duration-200">
                
                <div>
                    <div class="w-12 h-12 rounded-xl bg-primary-low text-primary flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-headline-md">meeting_room</span>
                    </div>

                    <h3 class="text-title-lg font-bold text-on-surface leading-tight">{{ $item->nama_ruangan }}</h3>
                    <p class="text-label-md text-outline mt-1 font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">corporate_fare</span>
                        <span>{{ $item->uppk }}</span>
                    </p>

                    <div class="grid grid-cols-2 gap-2 mt-4 pt-4 border-t border-border-subtle text-body-md text-on-surface-variant">
                        <div>
                            <span class="text-label-md text-outline block uppercase tracking-wider">Kapasitas</span>
                            <span class="font-semibold text-on-surface">{{ $item->kapasitas }} Kursi</span>
                        </div>
                        <div>
                            <span class="text-label-md text-outline block uppercase tracking-wider">Lokasi</span>
                            <span class="font-semibold text-on-surface truncate block">{{ $item->lokasi }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-border-subtle flex items-center justify-between gap-3">
                    <div>
                        @if($item->status == 'tersedia')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-emerald-50 text-success rounded-full border border-emerald-200">Tersedia</span>
                        @elseif($item->status == 'dipakai')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-surface-low text-outline rounded-full border border-border-subtle">Dipakai</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200">Perbaikan</span>
                        @endif
                    </div>

                    @if($item->status == 'tersedia')
                        <a href="{{ route('mahasiswa.peminjaman.create') }}?ruang_id={{ $item->id }}" 
                           class="inline-flex items-center gap-1.5 bg-primary text-on-primary px-4 py-2 rounded-xl text-xs font-bold hover:brightness-110 active:scale-95 transition-all">
                            <span>Pesan Ruang</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    @else
                        <button disabled class="inline-flex items-center gap-1.5 bg-surface-low text-outline px-4 py-2 rounded-xl text-xs font-bold opacity-50 cursor-not-allowed">
                            <span>Tidak Tersedia</span>
                        </button>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 bg-surface-container-low border border-border-subtle p-12 rounded-2xl text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-[48px] text-outline block mb-2">search_off</span>
                <span class="text-body-lg font-bold block">Ruangan Tidak Ditemukan</span>
                <span class="text-label-md text-outline mt-1 block">Cobalah untuk mengubah kata kunci pencarian atau menyetel ulang kombinasi dropdown filter Anda.</span>
            </div>
        @endforelse
    </div>

</div>

<script>
    let searchInput = document.querySelector('input[name="search"]');
    let timeout = null;

    searchInput.addEventListener('keyup', function () {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            document.getElementById('filterForm').submit();
        }, 600); 
    });
</script>
@endsection