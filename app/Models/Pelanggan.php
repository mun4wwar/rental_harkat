<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nama
 * @property string $email
 * @property string $no_telp
 * @property string|null $alamat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereNoTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaksi> $transaksis
 * @property-read int|null $transaksis_count
 * @mixin \Eloquent
 */
class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'no_telp',
        'alamat',
    ];

    public function transaksis()
{
    return $this->hasMany(Transaksi::class);
}
}
