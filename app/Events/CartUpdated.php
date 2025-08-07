<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class CartUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $cart;
    public $subtotal;
    public $tax;
    public $total;

    public function __construct($cart, $subtotal, $tax, $total)
    {
        $this->cart = $cart;
        $this->subtotal = $subtotal;
        $this->tax = $tax;
        $this->total = $total;
    }

    public function broadcastOn()
    {
        return new Channel('public-cart-channel');
    }
}