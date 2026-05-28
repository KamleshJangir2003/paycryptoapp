<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OtpMail extends Mailable
{
    public function __construct(public int $otp) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your FastpayoutX OTP');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.otp');
    }
}
