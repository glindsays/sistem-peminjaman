<?php

namespace Database\Seeders;

use App\Models\HariLibur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HariLiburSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HariLibur::create([
            'tanggal' => '2026-07-01',
            'keterangan' => 'Study Plan Registration (Masa Registrasi KRS)',
            'tipe_blokir' => 'blokir_akademik',
        ]);
        
        HariLibur::create([
            'tanggal' => '2026-07-02',
            'keterangan' => 'Study Plan Registration (Masa Registrasi KRS)',
            'tipe_blokir' => 'blokir_akademik',
        ]);

        HariLibur::create([
            'tanggal' => '2026-07-06',
            'keterangan' => 'Beginning of Semester (Hari Pertama Perkuliahan Kampus)',
            'tipe_blokir' => 'event_internal',
        ]);

        HariLibur::create([
            'tanggal' => '2026-07-07',
            'keterangan' => 'Study Plan Cancellation (Batas Akhir Pembatalan Matakuliah)',
            'tipe_blokir' => 'blokir_akademik',
        ]);

        HariLibur::create([
            'tanggal' => '2026-07-10',
            'keterangan' => 'Tuition Fee Payment Deadline (Batas Akhir Pembayaran Uang Kuliah)',
            'tipe_blokir' => 'blokir_akademik',
        ]);

        HariLibur::create([
            'tanggal' => '2026-08-17',
            'keterangan' => 'Independence Day (Hari Kemerdekaan RI - Kampus Libur Total)',
            'tipe_blokir' => 'libur_nasional',
        ]);
    }
}
