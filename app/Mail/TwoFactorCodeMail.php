<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $kode, public string $nama)
    {
    }

    public function build()
    {
        return $this->subject('Kode Verifikasi Login — SMK Fadlun Nafis')
            ->view('emails.two-factor-code');
    }
}