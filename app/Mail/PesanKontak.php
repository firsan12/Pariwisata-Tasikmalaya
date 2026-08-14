<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PesanKontak extends Mailable
{
    use Queueable, SerializesModels;

    public string $nama;
    public string $emailPengirim;
    public string $pesan;

    /**
     * Sesuai pemanggilan di KontakController::send():
     * new PesanKontak($request->nama, $request->email, $request->pesan)
     *
     * Nama properti di sini SENGAJA disamakan dengan variabel yang
     * dipakai di resources/views/emails/kontak.blade.php ($nama,
     * $emailPengirim, $pesan) — Blade otomatis bisa akses public
     * property Mailable ini lewat nama yang sama.
     */
    public function __construct(string $nama, string $email, string $pesan)
    {
        $this->nama          = $nama;
        $this->emailPengirim = $email;
        $this->pesan         = $pesan;
    }

    public function build()
    {
        return $this->subject('Pesan Baru dari Formulir Kontak - Wisata Tasikmalaya')
            ->replyTo($this->emailPengirim, $this->nama)
            ->view('emails.kontak');
    }
}