<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    protected $fillable = [
        'transaksi_id',
        'tanggal_pembayaran',
        'jumlah',
        'metode_pembayaran',
        'foto_bukti',
        'status_pembayaran',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
    ];

    // Accessor buat metode pembayaran (int -> string)
    public function getMetodePembayaranTextAttribute()
    {
        return match ($this->metode_pembayaran) {
            1 => 'Cash',
            2 => 'Transfer di Tempat',
            default => 'Tidak Diketahui',
        };
    }

    // Accessor buat status pembayaran (int -> string)
    public function getStatusPembayaranTextAttribute()
    {
        return match ($this->status_pembayaran) {
            0 => 'Belum Bayar',
            1 => 'Sudah Bayar',
            2 => 'Pending',
            default => 'Tidak Diketahui',
        };
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
