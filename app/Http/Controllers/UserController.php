<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('role', fn($q) => $q->where('nama_role', $request->role));
        }

        $users = $query->paginate(10)->withQueryString();
        $daftarRole = Role::all();

        return view('admin.user.index', compact('users', 'daftarRole'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        
        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'role_id' => $request->role_id
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Role untuk {$user->name} berhasil diperbarui!");
    }

    public function destroy(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $statusPesan = $user->is_active 
            ? "Akun {$user->name} berhasil diaktifkan kembali." 
            : "Akun {$user->name} telah dinonaktifkan.";

        return redirect()
            ->route('admin.users.index')
            ->with('success', $statusPesan);
    }
}
