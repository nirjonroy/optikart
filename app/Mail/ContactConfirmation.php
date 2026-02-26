<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function build()
    {
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');

        return $this->subject(__('We received your message'))
            ->from($fromAddress, $fromName)
            ->replyTo($fromAddress, $fromName)
            ->view('emails.contact-confirmation')
            ->with([
                'data' => $this->payload,
            ]);
    }
}
