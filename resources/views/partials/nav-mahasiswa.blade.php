<a href="{{ route('mahasiswa.dashboard') }}" 
   class="w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-body-md font-medium transition-all duration-200 {{ Request::is('mahasiswa/dashboard*') ? 'bg-primary-fixed text-on-primary-fixed-variant font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}">
    <span class="material-symbols-outlined">dashboard</span>
    <span>Dashboard</span>
</a>

<a href="{{ route('mahasiswa.ruang.index') }}" 
   class="w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-body-md font-medium transition-all duration-200 {{ Request::is('mahasiswa/katalog-ruangan*') ? 'bg-primary-fixed text-on-primary-fixed-variant font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}">
    <span class="material-symbols-outlined">meeting_room</span>
    <span>Katalog Ruangan</span>
</a>

<a href="{{ route('mahasiswa.peminjaman_barang.create') }}" 
   class="w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-body-md font-medium transition-all duration-200 {{ Request::is('mahasiswa/katalog-barang*') ? 'bg-primary-fixed text-on-primary-fixed-variant font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}">
    <span class="material-symbols-outlined">inventory_2</span>
    <span>Katalog Barang</span>
</a>