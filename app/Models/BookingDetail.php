<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'mobil_id',
        'pakai_supir',
        'supir_id',
        'nama_kota',
        'tanggal_sewa',
        'tanggal_kembali',
        'lama_sewa',
    ];

    protected $appends = [
        'tanggal_mulai_format',
        'tanggal_selesai_format',
        'total_harga_rp',
        'status_label',
    ];

    public function getAsalKotaLabelAttribute()
    {
        if ($this->asal_kota == 1) {
            return 'Yogyakarta';
        }
        return $this->nama_kota;
    }
    public function getStatusLabelAttribute()
    {
        return match ($this->booking?->status) {
            0 => 'Canceled',
            1 => 'Booked',
            2 => 'On Going',
            3 => 'Done',
            default => 'Tidak Diketahui',
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
    public function getTotalHargaRpAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    // Relasi ke Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    
    public function jobOffers()
    {
        return $this->hasMany(JobOffer::class, 'booking_detail_id');
    }

    // Relasi ke Mobil
    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    // Relasi ke Supir
    public function supir()
    {
        return $this->belongsTo(Supir::class);
    }
}
