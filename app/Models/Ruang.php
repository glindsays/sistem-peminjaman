<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_ruangan', 'kapasitas', 'lokasi', 'status', 'uppk'])]
class Ruang extends Model
{
    use HasFactory;

    protected $table = 'ruang';

    public function peminjamanRuang()
    {
        return $this->hasMany(PeminjamanRuang::class, 'ruang_id');
    }
}
