@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-5xl">
    
    <div class="flex items-center gap-4">
        <a href="{{ route('mahasiswa.ruang.index') }}" class="w-10 h-10 rounded-xl bg-surface-container hover:bg-surface-container-high flex items-center justify-center text-primary transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-headline-lg font-bold text-on-surface">Formulir Peminjaman Ruangan</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Lengkapi data detail agenda acara Anda untuk divalidasi oleh tim Koor / Dosen Pembina.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <div class="lg:col-span-1 bg-surface-container-low border border-border-subtle rounded-2xl p-5 space-y-4">
            <div class="flex items-center gap-2 pb-3 border-b border-outline-variant">
                <span class="material-symbols-outlined text-primary font-bold">info</span>
                <h3 class="text-title-md font-bold text-on-surface uppercase tracking-wider">Spesifikasi Fasilitas</h3>
            </div>

            @if($ruangTerpilih)
                <div class="space-y-4">
                    <div>
                        <span class="text-label-md text-outline block uppercase tracking-wider">Target Ruangan</span>
                        <span class="text-title-lg font-bold text-primary block mt-0.5">{{ $ruangTerpilih->nama_ruangan }}</span>
                    </div>
                    <div>
                        <span class="text-label-md text-outline block uppercase tracking-wider">Kapasitas Maksimal</span>
                        <span class="text-body-lg font-semibold text-on-surface block mt-0.5">{{ $ruangTerpilih->kapasitas }} Kursi / Orang</span>
                    </div>
                    <div>
                        <span class="text-label-md text-outline block uppercase tracking-wider">Lokasi Zona Gedung</span>
                        <span class="text-body-lg font-semibold text-on-surface block mt-0.5">{{ $ruangTerpilih->lokasi }}</span>
                    </div>
                    <div>
                        <span class="text-label-md text-outline block uppercase tracking-wider">Unit Penanggung Jawab</span>
                        <span class="text-body-md font-medium text-outline-variant block mt-0.5">{{ $ruangTerpilih->uppk }}</span>
                    </div>
                    <div class="p-3 bg-emerald-50 text-success border border-emerald-200 rounded-xl text-xs font-semibold flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-success"></span>
                        Status Fasilitas: Siap Digunakan
                    </div>
                </div>
            @else
                <div class="text-center py-6 text-on-surface-variant">
                    <span class="material-symbols-outlined text-[36px] text-outline block mb-2">meeting_room</span>
                    <p class="text-body-md font-medium">Belum ada ruangan yang dikunci.</p>
                    <p class="text-xs text-outline mt-1">Silakan pilih nama ruangan secara manual pada menu pilihan form di samping kanan.</p>
                </div>
            @endif
        </div>

        <div class="lg:col-span-2 bg-surface-container-lowest border border-border-subtle rounded-2xl p-6 shadow-soft">
            <form action="{{ route('mahasiswa.peminjaman.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label for="ruang_id_select" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Fasilitas Ruangan</label>
                    
                    @if($ruangTerpilih)
                        <div class="relative">
                            <select id="ruang_id_select" disabled class="w-full px-4 py-3 bg-surface-container border border-border-subtle rounded-lg text-body-md text-primary font-bold opacity-80 cursor-not-allowed appearance-none">
                                <option selected>{{ $ruangTerpilih->nama_ruangan }} (Locked)</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">lock</span>
                        </div>
                        <input type="hidden" name="ruang_id" value="{{ $ruangTerpilih->id }}">
                    @else
                        <div class="relative">
                            <select name="ruang_id" id="ruang_id_select" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer appearance-none" required>
                                <option value="">-- Pilih Ruangan Kampus --</option>
                                @foreach($semuaRuang as $r)
                                    <option value="{{ $r->id }}" {{ old('ruang_id') == $r->id ? 'selected' : '' }}>{{ $r->nama_ruangan }} (Kapasitas: {{ $r->kapasitas }} Kursi)</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                        </div>
                    @endif
                    @error('ruang_id') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="nama_acara" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Nama Kegiatan / Acara</label>
                    <input type="text" name="nama_acara" id="nama_acara" value="{{ old('nama_acara') }}" placeholder="Contoh: Rapat Koordinasi Anggota internal HIMA" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                    @error('nama_acara') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="nama_penyelenggara" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Unit Penyelenggara / Nama Ormawa</label>
                    <input type="text" name="nama_penyelenggara" id="nama_penyelenggara" value="{{ old('nama_penyelenggara') }}" placeholder="Contoh: BEM Petra / HIMA Informatika / UKM Musik" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                    @error('nama_penyelenggara') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="tgl_peminjaman" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Tanggal Pelaksanaan</label>
                    <div class="relative">
                        <input type="date" name="tgl_peminjaman" id="tgl_peminjaman" value="{{ old('tgl_peminjaman') }}" min="{{ date('Y-12-d') }}" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                    </div>
                    @error('tgl_peminjaman') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="waktu_mulai" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Waktu Mulai (Jam)</label>
                        <input type="time" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai') }}" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                        @error('waktu_mulai') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="waktu_selesai" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Waktu Selesai (Jam)</label>
                        <input type="time" name="waktu_selesai" id="waktu_selesai" value="{{ old('waktu_selesai') }}" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                        @error('waktu_selesai') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-border-subtle">
                    <a href="{{ route('mahasiswa.ruang.index') }}" class="px-5 py-3 text-body-md font-semibold text-outline hover:text-on-surface transition-colors">Batal</a>
                    <button type="submit" class="bg-primary text-on-primary font-bold px-6 py-3 rounded-lg shadow-sm hover:brightness-110 active:scale-[0.97] transition-all flex items-center gap-2 cursor-pointer">
                        <span class="material-symbols-outlined text-body-lg">send</span>
                        <span>Kirim Permohonan</span>
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection