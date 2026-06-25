<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Socialite;
use Illuminate\Support\Str;

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
                return redirect()->route('dosen.dashboard');
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

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email = $googleUser->getEmail();

            if (!Str::endsWith($email, ['@petra.ac.id', '@john.petra.ac.id'])) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Akses ditolak! Anda wajib login menggunakan Email Resmi Universitas Kristen Petra.'
                ]);
            }

            $roleName = 'mahasiswa'; 
            
            if ($email === 'baa@petra.ac.id') {
                $roleName = 'admin';
            } elseif (Str::endsWith($email, '@petra.ac.id')) {
                $roleName = 'dosen';
            } elseif (Str::endsWith($email, '@john.petra.ac.id')) {
                $roleName = 'mahasiswa';
            }

            $role = Role::where('nama_role', $roleName)->first();
            $roleId = $role ? $role->id : 2; 

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $googleUser->getName(),
                    'password' => Hash::make(Str::random(24)), 
                    'role_id' => $roleId,
                    'no_telp' => null, 
                ]
            );

            Auth::login($user);

            if ($roleName === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($roleName === 'dosen') {
                return redirect()->route('dosen.dashboard');
            } else {
                return redirect()->route('mahasiswa.dashboard');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal melakukan login via Google. Silakan coba kembali beberapa saat lagi.'
            ]);
        }
    }
}
