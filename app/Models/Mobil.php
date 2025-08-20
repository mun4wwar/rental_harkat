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
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $status_badge_class
 * @property-read mixed $status_text
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil whereHargaAllIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil whereHargaSewa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil whereNamaMobil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil wherePlatNomor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mobil whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaksi> $transaksis
 * @property-read int|null $transaksis_count
 * @mixin \Eloquent
 */

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobils'; // opsional sih, default-nya udah bener
    protected $fillable = [
        'nama_mobil',
        'tipe_id',
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

    public function getHargaPerHari(bool $pakaiSupir = false): int
    {
        return $pakaiSupir ? ($this->harga_all_in ?? 0) : ($this->harga_sewa ?? 0);
    }
    public function images()
    {
        return $this->hasMany(MobilImage::class);
    }
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function types()
    {
        return $this->belongsTo(TipeMobil::class, 'tipe_id');
    }
}
