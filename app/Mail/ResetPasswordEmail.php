<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $token;
    
    public function __construct($token)
    {
        $this->token = url('/password/reset/'.$token);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('omnifluencer@gmail.com', 'Omnifluencer')
                  ->subject('[Omnifluencer] Reset Password')
                  ->view('emails.forgot-password')
                  ->with('linkreset',$this->token);
    }
}
