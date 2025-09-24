<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Reset Password - Arisan Barokah')
                    ->view('emails.password-reset')
                    ->with([
                        'user' => $this->user,
                        'token' => $this->token,
                        'resetUrl' => route('password.reset', ['token' => $this->token, 'email' => $this->user->email])
                    ]);
    }
}