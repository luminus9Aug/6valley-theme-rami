<?php

namespace App\Listeners;

use App\Events\OrderCanceledEvent;

class OrderCanceledListener
{
    public function handle(OrderCanceledEvent $event)
    {
        $order = $event->order;
        $customer = $order->customer;

        // Access order and customer details
        $customerName = "{$customer->f_name} {$customer->l_name}";
        $customerMobile = $customer->mobile;
        $customerAddress = $customer->address;

        // Your logic here
    }
}