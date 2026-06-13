<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_barang', 'jumlah', 'status', 'uppk'])]
class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang'; 

    public function peminjamanBarang()
    {
        return $this->hasMany(PeminjamanBarang::class, 'barang_id');
    }
}