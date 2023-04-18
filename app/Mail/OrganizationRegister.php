<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganizationRegister extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $organization;
    public $user;
    public $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($organization,$user,$temppass)
    {
        $this->organization = $organization;
        $this->user = $user;
        $this->password = $temppass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.organizationcreated');
    }
}
