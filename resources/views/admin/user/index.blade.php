@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-headline-lg font-bold text-on-surface">Manajemen Pengguna</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Daftar otoritas, verifikasi, dan kontrol hak akses akun institusi civitas Petra Sifas.</p>
        </div>
        <div class="flex gap-3 bg-surface-container-low p-2 rounded-xl border border-border-subtle shrink-0">
            <div class="px-4 py-2 bg-surface-container-lowest rounded-lg shadow-xs text-center min-w-[80px]">
                <span class="text-label-md text-outline block font-medium uppercase">Total</span>
                <span class="text-title-lg font-bold text-on-surface">{{ $users->total() }}</span>
            </div>
        </div>
    </div>

    <div class="bg-surface-container-lowest border border-border-subtle p-4 rounded-xl shadow-soft">
        <form action="{{ route('admin.users.index') }}" method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2 space-y-1.5">
                <label class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Cari Pengguna</label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama atau email..."
                           class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low border border-border-subtle rounded-lg text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                </div>
            </div>
            <div class="space-y-1.5">
                <label class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">Filter Role</label>
                <div class="relative">
                    <select name="role" onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-4 py-2.5 bg-surface-container-low border border-border-subtle rounded-lg text-body-md appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">-- Semua Role --</option>
                        @foreach($daftarRole as $role)
                            <option value="{{ $role->nama_role }}" {{ request('role') == $role->nama_role ? 'selected' : '' }}>{{ ucfirst($role->nama_role) }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                </div>
            </div>
        </form>
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
                        <th class="p-4">Nama Pengguna</th>
                        <th class="p-4">Alamat Email</th>
                        <th class="p-4 w-40 text-center">Hak Akses (Role)</th>
                        <th class="p-4 w-40 text-center">Status Akun</th>
                        <th class="p-4 w-56 text-center">Aksi Kontrol</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-border-subtle text-body-md text-on-surface">
                        @forelse($users as $index => $user)
                        <tr class="hover:bg-surface-container-low transition-colors duration-150">
                            <td class="p-4 text-center text-outline font-medium">{{ $users->firstItem() + $index }}</td>
                            
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-surface-container font-bold text-primary flex items-center justify-center text-label-md shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <span class="font-semibold text-on-surface">{{ $user->name }}</span>
                                </div>
                            </td>
                            
                            <td class="p-4 text-on-surface-variant font-medium">{{ $user->email }}</td>
                            
                            <td class="p-4 text-center">
                                <span class="inline-block px-3 py-1 text-xs font-bold rounded-lg border uppercase tracking-wider
                                    @if($user->role->nama_role == 'admin') bg-amber-50 text-warning border-amber-200 
                                    @elseif($user->role->nama_role == 'dosen') bg-secondary-fixed text-on-secondary-fixed-variant border-secondary-fixed-dim
                                    @else bg-primary-fixed text-on-primary-fixed-variant border-primary-fixed-dim @endif">
                                    {{ $user->role->nama_role }}
                                </span>
                            </td>
                            
                            <td class="p-4 text-center">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold bg-emerald-50 text-success rounded-full border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-success animate-pulse"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold bg-rose-50 text-danger rounded-full border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-danger"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-surface-container hover:bg-surface-container-high text-primary rounded-xl text-xs font-semibold shadow-xs transition-all active:scale-95">
                                        <span class="material-symbols-outlined text-[16px]">manage_accounts</span>
                                        <span>Ubah Role</span>
                                    </a>

                                    <form id="deactivate-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        @if($user->is_active)
                                            <button type="button"
                                                    onclick="openDeactivateModal('deactivate-form-{{ $user->id }}', '{{ addslashes($user->name) }}')"
                                                    class="inline-flex items-center gap-1 px-3 py-2 bg-rose-50 hover:bg-error-container text-danger hover:text-on-error-container border border-rose-200 rounded-xl text-xs font-semibold shadow-xs transition-all active:scale-95 cursor-pointer">
                                                <span class="material-symbols-outlined text-[16px]">block</span>
                                                <span>Matikan</span>
                                            </button>
                                        @else
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-1 px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-success border border-emerald-200 rounded-xl text-xs font-semibold shadow-xs transition-all active:scale-95 cursor-pointer">
                                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                                <span>Aktifkan</span>
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] text-outline block mb-2">person_search</span>
                                <span class="text-body-lg font-bold block">Pengguna Tidak Ditemukan</span>
                                <span class="text-label-md text-outline mt-1 block">Coba ubah kata kunci pencarian atau filter role.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
    <div class="flex justify-center">
        {{ $users->links() }}
    </div>
    @endif
</div>

{{-- Deactivate Confirmation Modal --}}
<div id="deactivateModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50" onclick="closeDeactivateModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4">
        <div class="flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-danger text-[28px]">block</span>
            </div>
            <h2 class="text-title-md font-bold text-on-surface">Nonaktifkan Akun</h2>
            <p class="text-body-md text-on-surface-variant">Apakah Anda yakin ingin menonaktifkan akun <span id="deactivateUserName" class="font-bold text-on-surface"></span>? Pengguna tidak akan bisa masuk ke sistem.</p>
        </div>
        <div class="flex gap-3 mt-6">
            <button type="button" onclick="closeDeactivateModal()" class="flex-1 px-4 py-2.5 bg-surface-container hover:bg-surface-container-high text-on-surface-variant rounded-xl text-sm font-semibold transition-all cursor-pointer">Batal</button>
            <button type="button" id="deactivateConfirmBtn" class="flex-1 px-4 py-2.5 bg-danger hover:brightness-110 text-white rounded-xl text-sm font-semibold transition-all cursor-pointer">Ya, Nonaktifkan</button>
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

    function openDeactivateModal(formId, userName) {
        document.getElementById('deactivateUserName').textContent = userName;
        document.getElementById('deactivateConfirmBtn').onclick = () => document.getElementById(formId).submit();
        const modal = document.getElementById('deactivateModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeactivateModal() {
        const modal = document.getElementById('deactivateModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection