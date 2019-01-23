<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExpiredMembershipMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $emaildata;

    public function __construct($emaildata)
    {
      $this->emaildata = $emaildata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('omnifluencer@gmail.com', 'Omnifluencer')
                  ->subject('[Omnifluencer] Membership')
                  ->view('emails.expired-membership')
                  ->with($this->emaildata);
    }
}
