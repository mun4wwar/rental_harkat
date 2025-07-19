<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $status
 * @property string $nama_mobil
 * @property string $plat_nomor
 * @property string $merk
 * @property int $tahun
 * @property int $harga_sewa
 * @property int $harga_all_in
 * @property string $gambar
 */

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
        'harga_all_in',
        'status',
        'gambar',
    ];

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            0 => 'Rusak',
            1 => 'Tersedia',
            2 => 'Telah dibooking',
            3 => 'Telah disewa',
            4 => 'Sedang diservis',
            default => 'Status tidak diketahui',
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            0 => 'bg-red-100 text-red-800',
            1 => 'bg-green-100 text-green-800',
            2 => 'bg-amber-100 text-amber-800',
            3 => 'bg-blue-100 text-blue-800',
            4 => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-400',
        };
    }
}
