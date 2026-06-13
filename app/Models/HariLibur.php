<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['tanggal', 'keterangan', 'tipe_blokir'])]
class HariLibur extends Model
{
    use HasFactory;

    protected $table = 'hari_libur'; 
}