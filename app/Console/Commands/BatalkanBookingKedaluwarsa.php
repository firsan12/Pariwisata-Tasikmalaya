<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BatalkanBookingKedaluwarsa extends Command
{
    protected $signature = 'booking:batalkan-kedaluwarsa {--menit=60 : Batas waktu pembayaran dalam menit}';

    protected $description = 'Membatalkan booking berstatus pending yang sudah lewat batas waktu pembayaran, lalu mengembalikan kuota destinasi terkait.';

    public function handle(): int
    {
        $batasMenit = (int) $this->option('menit');

        $bookingKedaluwarsa = Booking::where('status', 'pending')
            ->where('created_at', '<=', now()->subMinutes($batasMenit))
            ->get();

        if ($bookingKedaluwarsa->isEmpty()) {
            $this->info('Tidak ada booking pending yang kedaluwarsa.');
            return self::SUCCESS;
        }

        $jumlahDibatalkan = 0;

        foreach ($bookingKedaluwarsa as $booking) {
            try {
                // Logika pembatalan sekarang satu-satunya sumber: Booking::batalkanDanKembalikanKuota()
                $booking->batalkanDanKembalikanKuota();

                $jumlahDibatalkan++;
                $this->line("Dibatalkan: {$booking->kode_booking}");
            } catch (\Throwable $e) {
                Log::error('Gagal membatalkan booking kedaluwarsa', [
                    'kode_booking' => $booking->kode_booking,
                    'error'        => $e->getMessage(),
                ]);
                $this->error("Gagal membatalkan {$booking->kode_booking}: {$e->getMessage()}");
            }
        }

        $this->info("Selesai. {$jumlahDibatalkan} booking dibatalkan & kuota dikembalikan.");

        return self::SUCCESS;
    }
}