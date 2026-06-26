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

    <div class="bg-surface-container-lowest border border-border-subtle rounded-xl shadow-soft overflow-hidden">
        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-border-subtle text-label-md text-outline font-bold bg-surface-container-low uppercase tracking-wider">
                        <th class="p-4 w-16 text-center">No</th>
                        <th class="p-4">Nama Ruangan</th>
                        <th class="p-4">Lokasi</th>
                        <th class="p-4 w-32 text-center">Kapasitas</th>
                        <th class="p-4">Unit Pengelola (UPPK)</th>
                        <th class="p-4 w-44 text-center">Status</th>
                        <th class="p-4 w-48 text-center">Aksi Kerja</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-border-subtle text-body-md text-on-surface">
                    @forelse($ruang as $index => $item)
                        <tr class="hover:bg-surface-container-low transition-colors duration-150">
                            <td class="p-4 text-center text-outline font-medium">{{ $index + 1 }}</td>
                            <td class="p-4 font-bold text-primary text-body-lg">{{ $item->nama_ruangan }}</td>
                            <td class="p-4 font-medium text-outline-variant">{{ $item->lokasi }}</td>
                            <td class="p-4 text-center font-bold bg-surface-container-low/40 text-on-surface">{{ $item->kapasitas }} Org</td>
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
                                @elseif(strtolower($item->status) == 'perbaikan')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-amber-50 text-warning rounded-full border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-warning"></span> Perbaikan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-danger"></span> {{ $item->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.ruang.edit', $item->id) }}" class="inline-flex items-center gap-1 px-3 py-2 bg-surface-container hover:bg-surface-container-high text-primary rounded-xl text-xs font-semibold shadow-xs transition-all active:scale-95">
                                        <span class="material-symbols-outlined text-[16px]">edit_square</span> Edit
                                    </a>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('admin.ruang.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="openDeleteModal('delete-form-{{ $item->id }}', '{{ addslashes($item->nama_ruangan) }}')" class="inline-flex items-center gap-1 px-3 py-2 bg-rose-50 hover:bg-error-container text-danger hover:text-on-error-container border border-rose-200 rounded-xl text-xs font-semibold shadow-xs transition-all active:scale-95 cursor-pointer">
                                            <span class="material-symbols-outlined text-[16px]">delete</span> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] text-outline block mb-2">meeting_room</span>
                                <span class="text-body-lg font-bold block">Ruangan Tidak Ditemukan</span>
                                <span class="text-label-md text-outline mt-1 block">Coba ubah kata kunci pencarian atau filter yang aktif.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden divide-y divide-border-subtle">
            @forelse($ruang as $index => $item)
                <div class="p-4 space-y-3">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="font-bold text-on-surface">{{ $item->nama_ruangan }}</div>
                            <div class="text-label-md text-outline flex items-center gap-1 mt-0.5">
                                <span class="material-symbols-outlined text-[13px]">corporate_fare</span> {{ $item->uppk }}
                            </div>
                        </div>
                        @if(strtolower($item->status) == 'tersedia')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-emerald-50 text-success rounded-full border border-emerald-200 shrink-0">Tersedia</span>
                        @elseif(strtolower($item->status) == 'perbaikan')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-amber-50 text-warning rounded-full border border-amber-200 shrink-0">Perbaikan</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200 shrink-0">{{ $item->status }}</span>
                        @endif
                    </div>
                    <div class="bg-surface-container-low rounded-xl px-3 py-2 text-label-md flex gap-4">
                        <div><span class="text-outline uppercase tracking-wider">Kapasitas</span><div class="font-bold text-on-surface">{{ $item->kapasitas }} Org</div></div>
                        <div><span class="text-outline uppercase tracking-wider">Lokasi</span><div class="font-semibold text-on-surface">{{ $item->lokasi }}</div></div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.ruang.edit', $item->id) }}" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 bg-surface-container hover:bg-surface-container-high text-primary rounded-xl text-xs font-semibold transition-all">
                            <span class="material-symbols-outlined text-[16px]">edit_square</span> Edit
                        </a>
                        <form id="delete-form-mob-{{ $item->id }}" action="{{ route('admin.ruang.destroy', $item->id) }}" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="button" onclick="openDeleteModal('delete-form-mob-{{ $item->id }}', '{{ addslashes($item->nama_ruangan) }}')" class="w-full inline-flex items-center justify-center gap-1 px-3 py-2 bg-rose-50 text-danger border border-rose-200 rounded-xl text-xs font-semibold transition-all cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">delete</span> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] text-outline block mb-2">meeting_room</span>
                    <span class="text-body-lg font-bold block">Ruangan Tidak Ditemukan</span>
                    <span class="text-label-md text-outline mt-1 block">Coba ubah kata kunci pencarian atau filter yang aktif.</span>
                </div>
            @endforelse
        </div>
    </div>

    @if($ruang->hasPages())
    <div class="flex justify-center">
        {{ $ruang->links() }}
    </div>
    @endif
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50" onclick="closeDeleteModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4">
        <div class="flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-danger text-[28px]">delete_forever</span>
            </div>
            <h2 class="text-title-md font-bold text-on-surface">Konfirmasi Hapus</h2>
            <p class="text-body-md text-on-surface-variant">Apakah Anda yakin ingin menghapus ruangan <span id="deleteItemName" class="font-bold text-on-surface"></span>? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="flex gap-3 mt-6">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 bg-surface-container hover:bg-surface-container-high text-on-surface-variant rounded-xl text-sm font-semibold transition-all cursor-pointer">Batal</button>
            <button type="button" id="deleteConfirmBtn" class="flex-1 px-4 py-2.5 bg-danger hover:brightness-110 text-white rounded-xl text-sm font-semibold transition-all cursor-pointer">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
    let searchInput = document.querySelector('input[name="search"]');
    let timeout = null;
    searchInput.addEventListener('keyup', function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => document.getElementById('filterForm').submit(), 600);
    });

    function openDeleteModal(formId, itemName) {
        document.getElementById('deleteItemName').textContent = itemName;
        document.getElementById('deleteConfirmBtn').onclick = () => document.getElementById(formId).submit();
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection