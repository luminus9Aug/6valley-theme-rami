<?php
namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCanceled extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $qrCode;

    public function __construct(Order $order, $qrCode)
    {
        $this->order = $order;
        $this->qrCode = $qrCode;
    }

    public function build()
    {
        return $this->view('emails.orderCanceled')
            ->with(['order' => $this->order, 'qrCode' => $this->qrCode]);
    }
}