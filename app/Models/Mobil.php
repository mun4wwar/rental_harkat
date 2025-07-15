<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobils'; // opsional sih, default-nya udah bener
    protected $fillable = [
        'nama_mobil',
        'plat_nomor',
        'merk',
        'tahun',
        'harga_sewa',
        'status',
        'gambar',
    ];
}
