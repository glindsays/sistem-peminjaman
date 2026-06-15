@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-headline-lg font-bold text-on-surface">Manajemen Inventaris Barang</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Kelola sirkulasi logistik, sisa stok barang, status ketersediaan, serta unit pengelola (UPPK) fasilitas kampus.</p>
        </div>
        <a href="{{ route('admin.barang.create') }}" class="inline-flex items-center gap-2 bg-secondary text-white px-5 py-3 rounded-xl text-body-md font-bold shadow-sm hover:brightness-110 active:scale-[0.98] transition-all shrink-0 justify-center">
            <span class="material-symbols-outlined text-body-lg">add</span>
            <span>Tambah Barang Baru</span>
        </a>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 text-success border border-emerald-200 rounded-xl shadow-xs transition-all animate-fade-in">
            <span class="material-symbols-outlined text-headline-md">check_circle</span>
            <span class="text-body-md font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-surface-container-lowest border border-border-subtle rounded-xl shadow-soft overflow-hidden">
        <div class="overflow-x-auto">
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
                            
                            <td class="p-4 text-center font-bold bg-surface-container-low/40 text-on-surface">
                                {{ $item->jumlah }} pcs
                            </td>
                            
                            <td class="p-4 font-medium text-outline-variant">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[18px] text-outline">corporate_fare</span>
                                    <span>{{ $item->uppk }}</span>
                                </div>
                            </td>
                            
                            <td class="p-4 text-center">
                                @if($item->status == 'tersedia')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-emerald-50 text-success rounded-full border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-danger"></span>
                                        Habis / Kosong
                                    </span>
                                @endif
                            </td>
                            
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.barang.edit', $item->id) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-surface-container hover:bg-surface-container-high text-primary rounded-xl text-xs font-semibold shadow-xs transition-all active:scale-95">
                                        <span class="material-symbols-outlined text-[16px]">edit_square</span>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('admin.barang.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus barang {{ $item->nama_barang }} dari sistem inventaris?')"
                                                class="inline-flex items-center gap-1 px-3 py-2 bg-rose-50 hover:bg-error-container text-danger hover:text-on-error-container border border-rose-200 rounded-xl text-xs font-semibold shadow-xs transition-all active:scale-95 cursor-pointer">
                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] text-outline block mb-2">inventory_2</span>
                                <span class="text-body-lg font-medium block">Belum Ada Data Inventaris Barang</span>
                                <span class="text-label-md text-outline mt-1 block">Silakan tambahkan log data barang baru melalui tombol di kanan atas.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection