<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 
                        'email',
                        function ($attribute, $value, $fail) {
                            if (!str_ends_with($value, '@petra.ac.id') && !str_ends_with($value, '@john.petra.ac.id')) {
                                $fail('Wajib menggunakan alamat email institusi UK Petra.');
                            }
                        }],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            if ($user->role->nama_role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role->nama_role === 'dosen') {
                return redirect()->route('dosendashboard');
            } elseif ($user->role->nama_role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password yang dimasukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
