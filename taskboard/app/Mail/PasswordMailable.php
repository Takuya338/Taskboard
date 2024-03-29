<?php
// app/Mail/PasswordMailable.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function build()
    {
        return $this->view('emails.templatcd e.password')
                    ->with(['password' => $this->password]);
    }
}
