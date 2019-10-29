<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class OrderUpdated extends Mailable
{
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        //
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.orders.updated');
    }
}
