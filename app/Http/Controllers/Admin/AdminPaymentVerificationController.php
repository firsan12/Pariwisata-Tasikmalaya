<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Semua route di controller ini WAJIB dilindungi middleware auth admin,
 * misalnya di routes/web.php:
 *
 *   Route::middleware(['auth', 'can:verify-payment'])
 *       ->prefix('admin')
 *       ->group(function () {
 *           Route::get('/verifikasi', [AdminPaymentVerificationController::class, 'index'])
 *               ->name('admin.verifikasi.index');
 *           Route::post('/verifikasi/{kodeBooking}/approve', [AdminPaymentVerificationController::class, 'approve'])
 *               ->name('admin.verifikasi.approve');
 *           Route::post('/verifikasi/{kodeBooking}/reject', [AdminPaymentVerificationController::class, 'reject'])
 *               ->name('admin.verifikasi.reject');
 *       });
 *
 * Jangan sekali-kali expose route ini tanpa middleware auth — inilah
 * satu-satunya jalur yang boleh mengubah status booking menjadi 'lunas'.
 */
class AdminPaymentVerificationController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('destinasi')
            ->where('status', 'menunggu_verifikasi')
            ->orderBy('klaim_bayar_at')
            ->paginate(20);

        return view('admin.verifikasi.index', compact('bookings'));
    }

    /**
     * Tampilkan foto bukti transfer secara aman.
     * File disimpan di disk 'private' (bukan 'public'), jadi TIDAK bisa
     * diakses lewat URL langsung — hanya lewat route ini yang dilindungi
     * middleware auth di grup route admin.
     */
    public function buktiTransfer(string $kodeBooking)
    {
        $booking = Booking::where('kode_booking', $kodeBooking)->firstOrFail();

        if (!$booking->bukti_transfer_path) {
            abort(404, 'Booking ini tidak memiliki bukti transfer.');
        }

        if (!Storage::disk('private')->exists($booking->bukti_transfer_path)) {
            abort(404, 'File bukti transfer tidak ditemukan.');
        }

        return Storage::disk('private')->response($booking->bukti_transfer_path);
    }

    public function approve(Request $request, string $kodeBooking)
    {
        $admin = $request->user(); // pastikan route pakai middleware auth

        $result = DB::transaction(function () use ($kodeBooking, $admin) {
            // lock row supaya tidak ada double-approve dari dua tab/admin sekaligus
            $booking = Booking::where('kode_booking', $kodeBooking)->lockForUpdate()->firstOrFail();

            if (!in_array($booking->status, ['pending', 'menunggu_verifikasi'], true)) {
                // sudah lunas / sudah dibatalkan — jangan diproses ulang
                return null;
            }

            $booking->update([
                'status'       => 'lunas',
                'dibayar_at'   => now(),
                'verified_by'  => $admin->id,
                'verified_ip'  => request()->ip(),
            ]);

            return $booking;
        });

        if (!$result) {
            return back()->withErrors(['status' => 'Booking sudah diproses sebelumnya atau tidak valid.']);
        }

        Log::info('Booking payment verified by admin', [
            'kode_booking' => $kodeBooking,
            'admin_id'     => $admin->id,
            'ip'           => $request->ip(),
        ]);

        return back()->with('success', "Booking {$kodeBooking} berhasil dikonfirmasi lunas.");
    }

    public function reject(Request $request, string $kodeBooking)
    {
        $admin = $request->user();

        $validated = $request->validate([
            'alasan' => 'required|string|max:500',
        ]);

        $booking = DB::transaction(function () use ($kodeBooking) {
            return Booking::where('kode_booking', $kodeBooking)->lockForUpdate()->firstOrFail();
        });

        if ($booking->status !== 'menunggu_verifikasi') {
            return back()->withErrors(['status' => 'Booking tidak sedang menunggu verifikasi.']);
        }

        $booking->update([
            'status'         => 'ditolak',
            'alasan_ditolak' => $validated['alasan'],
            'verified_by'    => $admin->id,
        ]);

        Log::warning('Booking payment claim rejected by admin', [
            'kode_booking' => $kodeBooking,
            'admin_id'     => $admin->id,
            'alasan'       => $validated['alasan'],
        ]);

        return back()->with('success', "Klaim pembayaran {$kodeBooking} ditolak.");
    }
}