<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QRCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $qrCodePath;
    public $eventTitle;

    public function __construct($qrCodePath, $eventTitle)
    {
        $this->qrCodePath = $qrCodePath;
        $this->eventTitle = $eventTitle;
    }

    public function build()
    {
        return $this->view('emails.qrcode')
            ->subject('Votre QR Code pour l\'événement')
            ->attach(storage_path('app/public/' . $this->qrCodePath))
            ->with([
                'eventTitle' => $this->eventTitle,
            ]);
    }
}
