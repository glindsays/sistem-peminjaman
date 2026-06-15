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
                <span class="text-title-lg font-bold text-on-surface">{{ $users->count() }}</span>
            </div>
        </div>
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
                    @foreach($users as $index => $user)
                        <tr class="hover:bg-surface-container-low transition-colors duration-150">
                            <td class="p-4 text-center text-outline font-medium">{{ $index + 1 }}</td>
                            
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

                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        @if($user->is_active)
                                            <button type="submit" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menonaktifkan akun {{ $user->name }}?')"
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection