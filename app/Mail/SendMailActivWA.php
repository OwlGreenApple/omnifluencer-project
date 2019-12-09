<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailActivWA extends Mailable
{
    use Queueable, SerializesModels;

    public $emaildata;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emaildata,$subject)
    {
        $this->emaildata = $emaildata;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this
        ->from('no-reply@omnifluencer.com', 'Omnifluencer')
                  ->subject($this->subject)
                  ->view('emails.send-mail-activwa')
                  ->with($this->emaildata);
    }

/* end mail class */
}
