<?php

namespace App\Events;

use App\Models\Transaksi;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobAssigned implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $transaksi;
    /**
     * Create a new event instance.
     */
    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return [new Channel('supir-available')];
    }

    public function broadcastWith()
    {
        return [
            'transaksi_id' => $this->transaksi->id,
            'mobil' => $this->transaksi->mobil->nama_mobil,
            'tanggal_sewa' => $this->transaksi->tanggal_sewa,
            'tanggal_kembali' => $this->transaksi->tanggal_kembali,
        ];
    }
}
