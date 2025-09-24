<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Pendaftaran Anda Telah Disetujui - Arisan Barokah')
                    ->view('emails.registration-approved')
                    ->with([
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                    ]);
    }
}