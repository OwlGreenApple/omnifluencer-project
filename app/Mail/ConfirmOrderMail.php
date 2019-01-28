<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;
    protected $order;
    public function __construct($user,$order)
    {
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('omnifluencer@gmail.com', 'Omnifluencer')
                  ->subject('[Omnifluencer] Konfirmasi Order')
                  ->view('emails.confirm-order')
                  ->with('user',$this->user)
                  ->with('order',$this->order);
    }
}
