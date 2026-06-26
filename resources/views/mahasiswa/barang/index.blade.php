@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <div>
        <h1 class="text-headline-lg font-bold text-on-surface">Katalog Inventaris Barang</h1>
        <p class="text-body-md text-on-surface-variant mt-1">Cari dan pinjam fasilitas peralatan penunjang kegiatan operasional acara ormawa Anda.</p>
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

    <div class="bg-surface-container-lowest border border-border-subtle p-4 rounded-xl shadow-soft">
        <form action="{{ route('mahasiswa.barang.index') }}" method="GET" id="filterBarangForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <div class="md:col-span-2 space-y-1.5">
                <label class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Cari Nama Barang</label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama printer, proyektor, kabel roll..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low border border-border-subtle rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Status Ketersediaan</label>
                <div class="relative">
                    <select name="status" onchange="document.getElementById('filterBarangForm').submit()" 
                            class="w-full px-4 py-2.5 bg-surface-container-low border border-border-subtle rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer appearance-none">
                        <option value="">-- Semua Status --</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia (Stok Ready)</option>
                        <option value="tidak tersedia" {{ request('status') == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia (Habis/Rusak)</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                </div>
            </div>

        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
        @forelse($barang as $item)
            <div class="bg-surface-container-lowest border border-border-subtle rounded-2xl p-5 shadow-soft flex flex-col justify-between hover:border-primary-fixed-dim hover:shadow-md transition-all duration-200">
                
                <div>
                    <div class="w-12 h-12 rounded-xl bg-primary-low text-primary flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-headline-md">inventory_2</span>
                    </div>

                    <h3 class="text-title-lg font-bold text-on-surface leading-tight truncate" title="{{ $item->nama_barang }}">{{ $item->nama_barang }}</h3>
                    <p class="text-label-md text-outline mt-1 font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">corporate_fare</span>
                        <span>{{ $item->uppk }}</span>
                    </p>

                    <div class="mt-4 pt-4 border-t border-border-subtle grid grid-cols-1 text-body-md">
                        <div class="bg-surface-container-low p-2.5 rounded-xl flex justify-between items-center">
                            <span class="text-label-md text-outline font-medium uppercase tracking-wider">Kapasitas Stok</span>
                            <span class="font-bold text-primary text-body-lg">{{ $item->jumlah }} Unit</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-border-subtle flex items-center justify-between gap-3">
                    <div>
                        @if($item->status == 'tersedia' && $item->jumlah > 0)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-emerald-50 text-success rounded-full border border-emerald-200">Tersedia</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200">Tidak Tersedia</span>
                        @endif
                    </div>

                    @if($item->status == 'tersedia' && $item->jumlah > 0)
                        <a href="{{ route('mahasiswa.barang.create') }}?barang_id={{ $item->id }}" 
                           class="inline-flex items-center gap-1.5 bg-primary text-on-primary px-4 py-2 rounded-xl text-xs font-bold hover:brightness-110 active:scale-95 transition-all">
                            <span>Ajukan Pinjam</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    @else
                        <button disabled class="inline-flex items-center gap-1.5 bg-surface-low text-outline px-4 py-2 rounded-xl text-xs font-bold opacity-50 cursor-not-allowed">
                            <span>Stok Habis</span>
                        </button>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 bg-surface-container-low border border-border-subtle p-12 rounded-2xl text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-[48px] text-outline block mb-2">search_off</span>
                <span class="text-body-lg font-bold block">Barang Tidak Ditemukan</span>
                <span class="text-label-md text-outline mt-1 block">Silakan ubah kata kunci pencarian real-time Anda.</span>
            </div>
        @endforelse
    </div>

    @if($barang->hasPages())
    <div class="flex justify-center">
        {{ $barang->links() }}
    </div>
    @endif

</div>

<script>
    let searchBarangInput = document.querySelector('input[name="search"]');
    let barangTimeout = null;

    searchBarangInput.addEventListener('keyup', function () {
        clearTimeout(barangTimeout);
        barangTimeout = setTimeout(function () {
            document.getElementById('filterBarangForm').submit();
        }, 600);
    });
</script>
@endsection