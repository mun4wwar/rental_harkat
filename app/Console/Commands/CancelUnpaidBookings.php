<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Notifications\BookingCanceledNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandCommand;

class CancelUnpaidBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:check-dp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek jatuh tempo DP booking dan auto cancel jika telat';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $bookings = Booking::where('status', 1) // 1 = booked
            ->whereHas('pembayaranDp', function ($q) use ($now) {
                $q->where('status_pembayaran', 0) // belum bayar
                    ->where('jatuh_tempo', '<', $now); // lewat tempo
            })
            ->with(['pembayaranDp', 'details.mobil', 'user'])
            ->get();

        foreach ($bookings as $booking) {
            $booking->update(['status' => 0]); // 0 = canceled

            foreach ($booking->details as $detail) {
                // cancel booking_detail
                $detail->update(['status' => 0]);
                
                if ($detail->mobil) {
                    $detail->mobil->update(['status' => 1]); // 1 = tersedia
                }
            }

            // kirim notif email
            $booking->user->notify(new BookingCanceledNotification($booking));

            $this->info("❌ Booking #{$booking->id} expired & canceled.");
        }

        return Command::SUCCESS;
    }
}
