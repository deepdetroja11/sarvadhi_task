<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $pdf;

    public function __construct($invoice, $pdf)
    {
        $this->invoice = $invoice;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Your Invoice')
                    ->view('emails.invoice')
                    ->attachData($this->pdf, 'invoice.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
