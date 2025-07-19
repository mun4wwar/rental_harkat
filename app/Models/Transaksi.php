<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property int $id
 * @property int $pelanggan_id
 * @property int $mobil_id
 * @property int|null $supir_id
 * @property string $tanggal_sewa
 * @property string $tanggal_kembali
 * @property int|null $lama_sewa
 * @property int|null $total_harga
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mobil $mobil
 * @property-read \App\Models\Pelanggan $pelanggan
 * @property-read \App\Models\Supir|null $supir
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereLamaSewa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereMobilId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi wherePelangganId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereSupirId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereTanggalKembali($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereTanggalSewa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereTotalHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Transaksi extends Model
{
    use HasFactory;

    const STATUS_BOOKED = 1;
    const STATUS_BERJALAN = 2;
    const STATUS_SELESAI = 3;

    protected $fillable = [
        'pelanggan_id',
        'mobil_id',
        'supir_id',
        'tanggal_sewa',
        'tanggal_kembali',
        'lama_sewa',
        'total_harga',
        'status',
    ];

    protected $appends = [
        'tanggal_mulai_format',
        'tanggal_selesai_format',
        'total_harga_rp',
        'status_label',
    ];

    // 🔁 Status label helper (static)
    public static function getStatusLabel($status): string
    {
        return match ($status) {
            self::STATUS_BOOKED => 'Booked',
            self::STATUS_BERJALAN => 'Berjalan',
            self::STATUS_SELESAI => 'Selesai',
            default => 'Unknown',
        };
    }

    // ✅ Accessor tanggal format
    protected function tanggalMulaiFormat(): Attribute
    {
        return Attribute::get(fn() => $this->tanggal_sewa
            ? Carbon::parse($this->tanggal_sewa)->translatedFormat('l, d F Y')
            : null);
    }

    protected function tanggalSelesaiFormat(): Attribute
    {
        return Attribute::get(fn() => $this->tanggal_kembali
            ? Carbon::parse($this->tanggal_kembali)->translatedFormat('l, d F Y')
            : null);
    }

    // ✅ Accessor format harga Rp
    protected function totalHargaRp(): Attribute
    {
        return Attribute::get(fn() => $this->total_harga !== null
            ? 'Rp ' . number_format($this->total_harga, 0, ',', '.')
            : '-');
    }

    // ✅ Status label (non-static, buat langsung di model)
    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn() => self::getStatusLabel($this->status));
    }

    // 🔗 Relasi
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function supir()
    {
        return $this->belongsTo(Supir::class);
    }
}
