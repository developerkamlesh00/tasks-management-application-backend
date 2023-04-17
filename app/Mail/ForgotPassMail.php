<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $token;
    public $username;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username,$token)
    {
        $this->token = $token;
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.forgotpasswordlink')->subject('Password Reset Link');
    }
}
