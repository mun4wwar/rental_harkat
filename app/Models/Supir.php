<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supir extends Model
{
    use HasFactory;

    protected $table = 'supirs'; // opsional sih, default-nya udah bener
    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
        'status'
    ];
}
