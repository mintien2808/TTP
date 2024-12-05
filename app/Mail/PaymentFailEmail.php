<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentFailEmail extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct($orderId, $message, $user)
    {
        $this->orderId = $orderId;
        $this->message = $message;
        $this->user = $user;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Fail Email',
        );
    }


    public function content(): Content
{
    return new Content(
        view: 'mail.payment_fail', 
        with: [
            'orderId' => $this->orderId,
            'message' => $this->message,
            'user' => $this->user,
        ]
    );
}


    public function attachments(): array
    {
        return [];
    }
}
