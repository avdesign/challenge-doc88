<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class OrderCreated extends Mailable
{
    public $order;

    /**
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.orders.created');
    }
}
