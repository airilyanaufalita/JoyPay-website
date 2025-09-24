<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Verifikasi Akun JoyPay')
                    ->view('emails.verify')
                    ->with([
                        'verificationLink' => url('/verify-email/' . $this->token),
                    ]);
    }
}
