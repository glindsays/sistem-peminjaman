<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = Role::where('nama_role', 'admin')->first()->id;
        $mahasiswaId = Role::where('nama_role', 'mahasiswa')->first()->id;
        $dosenId = Role::where('nama_role', 'dosen')->first()->id;

        User::create([
            'name' => 'Admin BAAK',
            'email' => 'baa@petra.ac.id',
            'password' => Hash::make('password123'),
            'role_id' => $adminId,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Gabrielle Lindsay',
            'email' => 'c14240001@john.petra.ac.id',
            'password' => Hash::make('password123'),
            'role_id' => $mahasiswaId,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Dosen Kaprodi',
            'email' => 'dosen@petra.ac.id',
            'password' => Hash::make('password123'),
            'role_id' => $dosenId,
            'is_active' => true,
        ]);
    }
}
