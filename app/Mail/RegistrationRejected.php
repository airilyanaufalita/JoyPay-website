<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $rejectionReason;
    public $improvementSuggestion;

    public function __construct($user, $rejectionReason, $improvementSuggestion = null)
    {
        $this->user = $user;
        $this->rejectionReason = $rejectionReason;
        $this->improvementSuggestion = $improvementSuggestion;
    }

    public function build()
    {
        return $this->subject('Pendaftaran Anda Ditolak - Arisan Barokah')
                    ->view('emails.registration-rejected')
                    ->with([
                        'name' => $this->user->name,
                        'rejectionReason' => $this->rejectionReason,
                        'improvementSuggestion' => $this->improvementSuggestion,
                    ]);
    }
}