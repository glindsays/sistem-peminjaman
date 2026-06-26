@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-5xl">
    
    <div class="flex items-center gap-4">
        <a href="{{ route('mahasiswa.barang.index') }}" class="w-10 h-10 rounded-xl bg-surface-container hover:bg-surface-container-high flex items-center justify-center text-primary transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-headline-lg font-bold text-on-surface">Formulir Peminjaman Barang</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Isi kuantitas jumlah barang dan durasi pengembalian inventaris sesuai dengan kebutuhan acara.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <div class="lg:col-span-1 bg-surface-container-low border border-border-subtle rounded-2xl p-5 space-y-4">
            <div class="flex items-center gap-2 pb-3 border-b border-outline-variant">
                <span class="material-symbols-outlined text-primary font-bold">info</span>
                <h3 class="text-title-md font-bold text-on-surface uppercase tracking-wider">Detail Logistik</h3>
            </div>

            @if($barangTerpilih)
                <div class="space-y-4">
                    <div>
                        <span class="text-label-md text-outline block uppercase tracking-wider">Nama Inventaris</span>
                        <span class="text-title-lg font-bold text-primary block mt-0.5">{{ $barangTerpilih->nama_barang }}</span>
                    </div>
                    <div>
                        <span class="text-label-md text-outline block uppercase tracking-wider">Maksimal Sisa Stok</span>
                        <span class="text-body-lg font-bold text-on-surface block mt-0.5">{{ $barangTerpilih->jumlah }} Unit / Pcs</span>
                    </div>
                    <div>
                        <span class="text-label-md text-outline block uppercase tracking-wider">Unit Penanggung Jawab</span>
                        <span class="text-body-md font-medium text-on-surface block mt-0.5">{{ $barangTerpilih->uppk }}</span>
                    </div>
                </div>
            @else
                <div class="text-center py-6 text-on-surface-variant">
                    <span class="material-symbols-outlined text-[36px] text-outline block mb-2">inventory_2</span>
                    <p class="text-body-md font-medium">Belum ada barang terpilih.</p>
                    <p class="text-xs text-outline mt-1">Silakan pilih inventaris secara manual di panel form kanan.</p>
                </div>
            @endif
        </div>

        <div class="lg:col-span-2 bg-surface-container-lowest border border-border-subtle rounded-2xl p-6 shadow-soft">
            <form action="{{ route('mahasiswa.barang.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label for="barang_id_select" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Nama Barang / Aset</label>
                    @if($barangTerpilih)
                        <div class="relative">
                            <select id="barang_id_select" disabled class="w-full px-4 py-3 bg-surface-container border border-border-subtle rounded-lg text-body-md text-primary font-bold opacity-80 cursor-not-allowed appearance-none">
                                <option selected>{{ $barangTerpilih->nama_barang }} </option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">lock</span>
                        </div>
                        <input type="hidden" name="barang_id" value="{{ $barangTerpilih->id }}">
                    @else
                        <div class="relative">
                            <select name="barang_id" id="barang_id_select" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer appearance-none" required>
                                <option value="">-- Pilih Barang Kampus --</option>
                                @foreach($semuaBarang as $b)
                                    <option value="{{ $b->id }}" {{ old('barang_id') == $b->id ? 'selected' : '' }}>{{ $b->nama_barang }} (Sisa Stok: {{ $b->jumlah }} pcs)</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                        </div>
                    @endif
                    @error('barang_id') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="jumlah_barang" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Kuantitas Jumlah Unit Yang Dipinjam</label>
                    <input type="number" name="jumlah_barang" id="jumlah_barang" value="{{ old('jumlah_barang', 1) }}" min="1" @if($barangTerpilih) max="{{ $barangTerpilih->jumlah }}" @endif placeholder="Masukkan angka kuantitas..." class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                    @error('jumlah_barang') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="nama_acara" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Nama Agenda Acara / Kegiatan</label>
                    <input type="text" name="nama_acara" id="nama_acara" value="{{ old('nama_acara') }}" placeholder="Contoh: Pengadaan Live Music UKM Musik Petra" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                    @error('nama_acara') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="nama_penyelenggara" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Organisasi Penyelenggara / Ormawa</label>
                    <input type="text" name="nama_penyelenggara" id="nama_penyelenggara" value="{{ old('nama_penyelenggara') }}" placeholder="Contoh: HIMA Petra / Unit Kegiatan Mahasiswa" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                    @error('nama_penyelenggara') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="tgl_peminjaman" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Tanggal Mulai Pinjam</label>
                        <input type="date" name="tgl_peminjaman" id="tgl_peminjaman" value="{{ old('tgl_peminjaman') }}" min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                        @error('tgl_peminjaman') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="space-y-2">
                        <label for="tgl_pengembalian" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Tanggal Target Pengembalian</label>
                        <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" value="{{ old('tgl_pengembalian') }}" min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                        @error('tgl_pengembalian') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-2">
                    <span id="error-tanggal" class="text-xs font-bold block"></span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="waktu_mulai" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Waktu Ambil (Jam)</label>
                        <input type="time" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai') }}" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                        @error('waktu_mulai') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="waktu_selesai" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Waktu Pengembalian (Jam)</label>
                        <input type="time" name="waktu_selesai" id="waktu_selesai" value="{{ old('waktu_selesai') }}" class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" required>
                        @error('waktu_selesai') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-border-subtle">
                    <a href="{{ route('mahasiswa.barang.index') }}" class="px-5 py-3 text-body-md font-semibold text-outline hover:text-on-surface transition-colors">Batal</a>
                    <button type="submit" id="btn-submit" class="bg-primary text-on-primary font-bold px-6 py-3 rounded-lg shadow-sm hover:brightness-110 active:scale-[0.97] transition-all flex items-center gap-2 cursor-pointer">
                        <span class="material-symbols-outlined text-body-lg">send</span>
                        <span>Kirim Formulir</span>
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
<script>
const tglPinjamInput = document.getElementById('tgl_peminjaman');
const tglKembaliInput = document.getElementById('tgl_pengembalian');
const errorContainer = document.getElementById('error-tanggal'); 
const btnSubmit = document.getElementById('btn-submit');

function validasiKalenderAkademik() {
    if (!errorContainer) return;

    const tglPinjam = tglPinjamInput.value;
    const tglKembali = tglKembaliInput.value;

    if (!tglPinjam && !tglKembali) return;

    errorContainer.textContent = 'Mengecek kalender akademik kampus...';
    errorContainer.style.color = 'orange';

    const cekPinjam = tglPinjam 
        ? fetch(`/mahasiswa/ajax/campus/calendar?tanggal=${tglPinjam}`).then(r => r.json())
        : Promise.resolve({ bisa_pinjam_fasilitas: true });

    const cekKembali = tglKembali 
        ? fetch(`/mahasiswa/ajax/campus/calendar?tanggal=${tglKembali}`).then(r => r.json())
        : Promise.resolve({ bisa_pinjam_fasilitas: true });

    Promise.all([cekPinjam, cekKembali])
        .then(([resPinjam, resKembali]) => {
            if (resPinjam.bisa_pinjam_fasilitas === false) {
                errorContainer.textContent = `Tanggal Mulai Pinjam: ${resPinjam.keterangan}`;
                errorContainer.style.color = '#EF4444'; 
                setTombolSubmit(true); 
            } else if (resKembali.bisa_pinjam_fasilitas === false) {
                errorContainer.textContent = `Tanggal Pengembalian: ${resKembali.keterangan}`;
                errorContainer.style.color = '#EF4444'; 
                setTombolSubmit(true);
            } else {
                setTombolSubmit(false); 
            }
        })
        .catch(error => {
            console.error('API Error:', error);
            errorContainer.textContent = '⚠️ Terjadi kesalahan pada validasi data API.';
            errorContainer.style.color = '#EF4444'; 
            setTombolSubmit(true);
        });
}

function setTombolSubmit(isLocked) {
    if (!btnSubmit) return;
    btnSubmit.disabled = isLocked;
    btnSubmit.style.opacity = isLocked ? '0.5' : '1';
    btnSubmit.style.cursor = isLocked ? 'not-allowed' : 'pointer';
}

if (tglPinjamInput) tglPinjamInput.addEventListener('change', validasiKalenderAkademik);
if (tglKembaliInput) tglKembaliInput.addEventListener('change', validasiKalenderAkademik);
</script>
@endsection