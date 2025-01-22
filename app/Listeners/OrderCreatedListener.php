<?php
// app/Listeners/OrderCreatedListener.php
namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Mail;

class OrderCreatedListener
{
    public function handle(OrderCreatedEvent $event)
    {
        $order = $event->order;
        $customer = $order->customer;

        // Generate QR code
        $qrCode = QrCode::format('png')->size(200)->generate("Order ID: {$order->id}, Customer: {$customer->name}");

        // Send notification (example using Mail)
        Mail::to($customer->email)->send(new \App\Mail\OrderCreated($order, $qrCode));
    }
}