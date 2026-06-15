@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-2xl">
    
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" 
           class="w-10 h-10 rounded-xl bg-surface-container hover:bg-surface-container-high flex items-center justify-center text-primary transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-headline-lg font-bold text-on-surface">Ubah Peran Pengguna</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Konfigurasi ulang hak akses dan tingkatan manajemen aplikasi.</p>
        </div>
    </div>

    <div class="bg-surface-container-lowest border border-border-subtle rounded-xl p-6 shadow-soft space-y-6">
        
        <div class="flex items-center gap-4 p-4 bg-surface-container-low rounded-xl border border-border-subtle">
            <div class="w-12 h-12 rounded-full bg-primary-fixed text-on-primary-fixed-variant flex items-center justify-center font-bold text-body-lg">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div class="flex flex-col truncate">
                <span class="text-body-lg font-bold text-on-surface truncate">{{ $user->name }}</span>
                <span class="text-body-md text-outline truncate">{{ $user->email }}</span>
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label for="role_id" class="text-label-md font-bold text-on-surface-variant block uppercase tracking-wider">
                    Pilih Peran Baru (Role)
                </label>
                <div class="relative group">
                    <select name="role_id" id="role_id" 
                            class="w-full px-4 py-3 bg-surface-container-low border border-border-subtle rounded-lg text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer appearance-none">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->nama_role) }}
                            </option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">
                        arrow_drop_down
                    </span>
                </div>
                @error('role_id')
                    <p class="text-xs text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-border-subtle">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-5 py-3 text-body-md font-semibold text-outline hover:text-on-surface transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-primary text-on-primary font-bold px-6 py-3 rounded-lg shadow-sm hover:brightness-110 active:scale-[0.97] transition-all flex items-center gap-2 cursor-pointer">
                    <span class="material-symbols-outlined text-body-lg">save</span>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection