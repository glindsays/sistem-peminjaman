@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-2xl">
    
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.ruang.index') }}" class="w-10 h-10 rounded-xl bg-surface-container hover:bg-surface-container-high flex items-center justify-center text-primary transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-headline-lg font-bold text-on-surface">Tambah Ruangan Baru</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Masukkan data spesifikasi ruangan kuliah atau laboratorium baru ke dalam database.</p>
        </div>
    </div>

    <div class="bg-surface-container-lowest border border-border-subtle rounded-xl p-6 shadow-soft">
        <form action="{{ route('admin.ruang.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="space-y-2">
                <label for="nama_ruangan" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Nama Ruangan</label>
                <input type="text" name="nama_ruangan" id="nama_ruangan" value="{{ old('nama_ruangan') }}" placeholder="Contoh: Gedung T Lantai 4 - T402" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                @error('nama_ruangan') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label for="kapasitas" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Kapasitas Maksimal (Orang)</label>
                <input type="number" name="kapasitas" id="kapasitas" value="{{ old('kapasitas') }}" min="1" placeholder="Contoh: 40" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                @error('kapasitas') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label for="lokasi" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Lokasi / Gedung Kampus</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Gedung T Kampus Pusat" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                @error('lokasi') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label for="status" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Status Awal Ruangan</label>
                <div class="relative">
                    <select name="status" id="status" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer appearance-none" required>
                        <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia (Siap Digunakan)</option>
                        <option value="Perbaikan" {{ old('status') == 'Perbaikan' ? 'selected' : '' }}>Tidak Tersedia (Perbaikan))</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                </div>
                @error('status') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label for="uppk" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Unit Pengelola (UPPK)</label>
                <input type="text" name="uppk" id="uppk" value="{{ old('uppk') }}" placeholder="Contoh: Tata Usaha / BAAK Gedung T" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                @error('uppk') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-border-subtle">
                <a href="{{ route('admin.ruang.index') }}" class="px-5 py-3 text-body-md font-semibold text-outline hover:text-on-surface transition-colors">Batal</a>
                <button type="submit" class="bg-primary text-on-primary font-bold px-6 py-3 rounded-lg shadow-sm hover:brightness-110 active:scale-[0.97] transition-all flex items-center gap-2 cursor-pointer">
                    <span class="material-symbols-outlined text-body-lg">save</span>
                    <span>Daftarkan Ruangan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection