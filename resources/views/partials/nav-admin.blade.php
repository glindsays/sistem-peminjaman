<a href="{{ route('admin.dashboard') }}" 
   class="w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-body-md font-medium transition-all duration-200 {{ Request::is('admin/dashboard*') ? 'bg-primary-fixed text-on-primary-fixed-variant font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}">
    <span class="material-symbols-outlined">dashboard</span>
    <span>Dashboard</span>
</a>

<a href="{{ route('admin.users.index') }}" 
   class="w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-body-md font-medium transition-all duration-200 {{ Request::is('admin/users*') ? 'bg-primary-fixed text-on-primary-fixed-variant font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}">
    <span class="material-symbols-outlined">manage_accounts</span>
    <span>Kelola Pengguna</span>
</a>

<a href="{{ route('admin.ruang.index') }}" 
   class="w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-body-md font-medium transition-all duration-200 {{ Request::is('admin/ruang*') ? 'bg-primary-fixed text-on-primary-fixed-variant font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}">
    <span class="material-symbols-outlined">meeting_room</span>
    <span>Data Ruangan</span>
</a>

<a href="{{ route('admin.barang.index') }}" 
   class="w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-body-md font-medium transition-all duration-200 {{ Request::is('admin/barang*') ? 'bg-primary-fixed text-on-primary-fixed-variant font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}">
    <span class="material-symbols-outlined">inventory_2</span>
    <span>Data Barang</span>
</a>