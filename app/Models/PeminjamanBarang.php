<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id', 
    'barang_id', 
    'jumlah_barang', 
    'nama_acara', 
    'nama_penyelenggara', 
    'waktu_mulai', 
    'waktu_selesai', 
    'tgl_peminjaman', 
    'tgl_pengembalian', 
    'status_izin'
])]
class PeminjamanBarang extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_barang';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}