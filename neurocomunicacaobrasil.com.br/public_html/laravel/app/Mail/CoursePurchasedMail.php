<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CoursePurchasedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $course;

    public function __construct($user, $course)
    {
        $this->user = $user;
        $this->course = $course;
    }

    public function build()
    {
        return $this->subject('Compra confirmada!')
                    ->markdown('emails.course-purchased');
    }
}