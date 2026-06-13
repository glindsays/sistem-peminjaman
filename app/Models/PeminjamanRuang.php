<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id', 
    'ruang_id', 
    'nama_acara', 
    'nama_penyelenggara', 
    'waktu_mulai', 
    'waktu_selesai', 
    'tgl_peminjaman', 
    'status_izin'
])]
class PeminjamanRuang extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_ruang';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'ruang_id');
    }
}