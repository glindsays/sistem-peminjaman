<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_role'])]
class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}