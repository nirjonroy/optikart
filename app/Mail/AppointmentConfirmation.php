<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public Appointment $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');

        return $this->subject(__('Your Optikart appointment request'))
            ->from($fromAddress, $fromName)
            ->replyTo($this->appointment->email, $this->appointment->name)
            ->view('emails.appointment-confirmation')
            ->with([
                'appointment' => $this->appointment,
            ]);
    }
}
