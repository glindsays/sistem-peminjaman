<?php

namespace Database\Seeders;

use App\Models\Ruang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // gedung q
        $floorsQ = [3, 9];
        foreach ($floorsQ as $floor) {
            for ($i = 1; $i <= 9; $i++) {
                foreach (['a', 'b'] as $suffix) {
                    Ruang::create([
                        'nama_ruangan' => "Q.{$floor}0{$i}{$suffix}",
                        'kapasitas' => rand(70, 200), 
                        'lokasi' => 'Gedung Q',
                        'status' => 'tersedia',
                        'uppk' => 'Q',
                    ]);
                }
            }
        }
        
        Ruang::create([
            'nama_ruangan' => 'Amphitheater Q',
            'kapasitas' => 400,
            'lokasi' => 'Gedung Q',
            'status' => 'tersedia',
            'uppk' => 'Q',
        ]);

        Ruang::create([
            'nama_ruangan' => 'Auditorium Q',
            'kapasitas' => 1500,
            'lokasi' => 'Gedung Q',
            'status' => 'tersedia',
            'uppk' => 'Q',
        ]);


        // gedung p
        for ($i = 1; $i <= 3; $i++) {
            Ruang::create([
                'nama_ruangan' => "P.20{$i}",
                'kapasitas' => 100,
                'lokasi' => 'Gedung P',
                'status' => 'tersedia',
                'uppk' => 'P',
            ]);
        }

        for ($floor = 3; $floor <= 5; $floor++) {
            for ($room = 1; $room <= 15; $room++) {
                $roomNumber = sprintf("%02d", $room); 
                Ruang::create([
                    'nama_ruangan' => "P.{$floor}{$roomNumber}",
                    'kapasitas' => 100,
                    'lokasi' => 'Gedung P',
                    'status' => 'tersedia',
                    'uppk' => 'P',
                ]);
            }
        }

        for ($i = 1; $i <= 7; $i++) {
            Ruang::create([
                'nama_ruangan' => "P.70{$i}",
                'kapasitas' => 150,
                'lokasi' => 'Gedung P',
                'status' => 'tersedia',
                'uppk' => 'P',
            ]);
        }


        // gedung w
        for ($i = 1; $i <= 3; $i++) {
            Ruang::create([
                'nama_ruangan' => "W.30{$i}",
                'kapasitas' => 60,
                'lokasi' => 'Gedung W',
                'status' => 'tersedia',
                'uppk' => 'W',
            ]);
        }

        // Auditorium W
        Ruang::create([
            'nama_ruangan' => 'Auditorium W',
            'kapasitas' => 700,
            'lokasi' => 'Gedung W',
            'status' => 'tersedia',
            'uppk' => 'W',
        ]);


        // gedung t
        for ($floor = 3; $floor <= 5; $floor++) {
            for ($room = 1; $room <= 15; $room++) {
                $roomNumber = sprintf("%02d", $room);
                Ruang::create([
                    'nama_ruangan' => "T.{$floor}{$roomNumber}",
                    'kapasitas' => rand(70, 200),
                    'lokasi' => 'Gedung T',
                    'status' => 'tersedia',
                    'uppk' => 'T',
                ]);
            }
        }

        for ($i = 1; $i <= 3; $i++) {
            Ruang::create([
                'nama_ruangan' => "AVT.50{$i}",
                'kapasitas' => 1000, 
                'lokasi' => 'Gedung T',
                'status' => 'tersedia',
                'uppk' => 'T', 
            ]);
        }
    }
}
