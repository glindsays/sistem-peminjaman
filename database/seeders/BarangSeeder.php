<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Barang::create([
            'nama_barang' => 'Kursi Lipat (Standard)',
            'jumlah' => 500,
            'status' => 'tersedia',
            'uppk' => 'T',
        ]);

        Barang::create([
            'nama_barang' => 'Kursi VIP Padded (Busa)',
            'jumlah' => 100,
            'status' => 'tersedia',
            'uppk' => 'T',
        ]);

        Barang::create([
            'nama_barang' => 'Meja Kotak IBM',
            'jumlah' => 60,
            'status' => 'tersedia',
            'uppk' => 'T',
        ]);

        Barang::create([
            'nama_barang' => 'Meja Bundar Banquet (Round Table)',
            'jumlah' => 20,
            'status' => 'tersedia',
            'uppk' => 'T',
        ]);

        Barang::create([
            'nama_barang' => 'Sofa Single VIP (Hitam)',
            'jumlah' => 12,
            'status' => 'tersedia',
            'uppk' => 'T',
        ]);

        Barang::create([
            'nama_barang' => 'Sofa Double VIP (Hitam)',
            'jumlah' => 6,
            'status' => 'tersedia',
            'uppk' => 'T',
        ]);

        Barang::create([
            'nama_barang' => 'Seat Cover Kain Putih (Kursi Lipat)',
            'jumlah' => 400,
            'status' => 'tersedia',
            'uppk' => 'T',
        ]);

        Barang::create([
            'nama_barang' => 'Cover Meja Kotak Maroon',
            'jumlah' => 60,
            'status' => 'tersedia',
            'uppk' => 'T',
        ]);

        Barang::create([
            'nama_barang' => 'Cover Meja Bundar Putih',
            'jumlah' => 25,
            'status' => 'tersedia',
            'uppk' => 'T',
        ]);

        Barang::create([
            'nama_barang' => 'Microphone Wireless (Handheld)',
            'jumlah' => 16,
            'status' => 'tersedia',
            'uppk' => 'Q',
        ]);

        Barang::create([
            'nama_barang' => 'Microphone Clip-On / Wireless Headset',
            'jumlah' => 8,
            'status' => 'tersedia',
            'uppk' => 'Q',
        ]);

        Barang::create([
            'nama_barang' => 'Kabel Olor / Extension Gulung 10 Meter',
            'jumlah' => 35,
            'status' => 'tersedia',
            'uppk' => 'Q',
        ]);

        Barang::create([
            'nama_barang' => 'Kabel Olor / Extension Gulung 25 Meter',
            'jumlah' => 15,
            'status' => 'tersedia',
            'uppk' => 'Q',
        ]);

        Barang::create([
            'nama_barang' => 'Handie Talkie (HT) UHF/VHF Dual Band', 
            'jumlah' => 50,
            'status' => 'tersedia',
            'uppk' => 'Q',
        ]);

        Barang::create([
            'nama_barang' => 'Earpiece HT Clear Acoustic Tube',
            'jumlah' => 50,
            'status' => 'tersedia',
            'uppk' => 'Q',
        ]);
    }
}
