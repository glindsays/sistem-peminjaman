@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-headline-lg font-bold text-on-surface">Manajemen Inventaris Barang</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Kelola sirkulasi logistik, stok barang, status ketersediaan, serta unit pengelola (UPPK).</p>
        </div>
        <a href="{{ route('admin.barang.create') }}" 
           class="inline-flex items-center gap-2 bg-primary text-white px-5 py-3 rounded-xl text-body-md font-bold shadow-sm hover:brightness-110 active:scale-[0.98] transition-all shrink-0 justify-center">
            <span class="material-symbols-outlined text-body-lg">add</span>
            <span>Tambah Barang Baru</span>
        </a>
    </div>

    <div class="bg-surface-container-lowest border border-border-subtle p-4 rounded-xl shadow-soft">
        <form action="{{ route('admin.barang.index') }}" method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <div class="space-y-1.5">
                <label class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Cari Barang</label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama barang..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low border border-border-subtle rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Unit Pengelola</label>
                <div class="relative">
                    <select name="uppk" onchange="document.getElementById('filterForm').submit()" 
                            class="w-full px-4 py-2.5 bg-surface-container-low border border-border-subtle rounded-lg text-body-md appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">-- Semua Unit --</option>
                        @foreach($daftarUPPK as $uppk)
                            <option value="{{ $uppk }}" {{ request('uppk') == $uppk ? 'selected' : '' }}>{{ $uppk }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Status Barang</label>
                <div class="relative">
                    <select name="status" onchange="document.getElementById('filterForm').submit()" 
                            class="w-full px-4 py-2.5 bg-surface-container-low border border-border-subtle rounded-lg text-body-md appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">-- Semua Status --</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak tersedia" {{ request('status') == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                </div>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 text-success border border-emerald-200 rounded-xl shadow-xs animate-fade-in">
            <span class="material-symbols-outlined text-headline-md">check_circle</span>
            <span class="text-body-md font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-surface-container-lowest border border-border-subtle rounded-xl shadow-soft overflow-hidden">
        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-border-subtle text-label-md text-outline font-bold bg-surface-container-low uppercase tracking-wider">
                        <th class="p-4 w-16 text-center">No</th>
                        <th class="p-4">Nama Barang</th>
                        <th class="p-4 w-32 text-center">Stok Jumlah</th>
                        <th class="p-4">Unit Pengelola (UPPK)</th>
                        <th class="p-4 w-44 text-center">Status</th>
                        <th class="p-4 w-48 text-center">Aksi Kerja</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-border-subtle text-body-md text-on-surface">
                    @forelse($barang as $index => $item)
                        <tr class="hover:bg-surface-container-low transition-colors duration-150">
                            <td class="p-4 text-center text-outline font-medium">{{ $index + 1 }}</td>
                            <td class="p-4 font-bold text-secondary text-body-lg">{{ $item->nama_barang }}</td>
                            <td class="p-4 text-center font-bold bg-surface-container-low/40 text-on-surface">{{ $item->jumlah }} pcs</td>
                            <td class="p-4 font-medium text-outline-variant">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[18px] text-outline">corporate_fare</span>
                                    <span>{{ $item->uppk }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                @if(strtolower($item->status) == 'tersedia')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-emerald-50 text-success rounded-full border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span> Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-danger"></span> Tidak Tersedia
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.barang.edit', $item->id) }}" class="inline-flex items-center gap-1 px-3 py-2 bg-surface-container hover:bg-surface-container-high text-primary rounded-xl text-xs font-semibold shadow-xs transition-all active:scale-95">
                                        <span class="material-symbols-outlined text-[16px]">edit_square</span> Edit
                                    </a>
                                    <form action="{{ route('admin.barang.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')" class="inline-flex items-center gap-1 px-3 py-2 bg-rose-50 hover:bg-error-container text-danger hover:text-on-error-container border border-rose-200 rounded-xl text-xs font-semibold shadow-xs transition-all active:scale-95 cursor-pointer">
                                            <span class="material-symbols-outlined text-[16px]">delete</span> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] text-outline block mb-2">inventory_2</span>
                                <span class="text-body-lg font-bold block">Barang Tidak Ditemukan</span>
                                <span class="text-label-md text-outline mt-1 block">Coba ubah kata kunci pencarian atau filter yang aktif.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden divide-y divide-border-subtle">
            @forelse($barang as $index => $item)
                <div class="p-4 space-y-3">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="font-bold text-on-surface">{{ $item->nama_barang }}</div>
                            <div class="text-label-md text-outline flex items-center gap-1 mt-0.5">
                                <span class="material-symbols-outlined text-[13px]">corporate_fare</span> {{ $item->uppk }}
                            </div>
                        </div>
                        @if(strtolower($item->status) == 'tersedia')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-emerald-50 text-success rounded-full border border-emerald-200 shrink-0">Tersedia</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200 shrink-0">Tidak Tersedia</span>
                        @endif
                    </div>
                    <div class="bg-surface-container-low rounded-xl px-3 py-2 text-label-md">
                        <span class="text-outline uppercase tracking-wider">Stok</span>
                        <span class="font-bold text-on-surface ml-2">{{ $item->jumlah }} pcs</span>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.barang.edit', $item->id) }}" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 bg-surface-container hover:bg-surface-container-high text-primary rounded-xl text-xs font-semibold transition-all">
                            <span class="material-symbols-outlined text-[16px]">edit_square</span> Edit
                        </a>
                        <form action="{{ route('admin.barang.destroy', $item->id) }}" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus barang ini?')" class="w-full inline-flex items-center justify-center gap-1 px-3 py-2 bg-rose-50 text-danger border border-rose-200 rounded-xl text-xs font-semibold transition-all cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">delete</span> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] text-outline block mb-2">inventory_2</span>
                    <span class="text-body-lg font-bold block">Barang Tidak Ditemukan</span>
                    <span class="text-label-md text-outline mt-1 block">Coba ubah kata kunci pencarian atau filter yang aktif.</span>
                </div>
            @endforelse
        </div>
    </div>

    @if($barang->hasPages())
    <div class="flex justify-center">
        {{ $barang->links() }}
    </div>
    @endif
</div>


<script>
    let searchInput = document.querySelector('input[name="search"]');
    let timeout = null;
    searchInput.addEventListener('keyup', function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => document.getElementById('filterForm').submit(), 600);
    });
</script>
@endsection