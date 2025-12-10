<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccessGrantedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $course;

    public function __construct(User $user, string $password, Course $course)
    {
        $this->user = $user;
        $this->password = $password;
        $this->course = $course;
    }

    public function build()
    {
        return $this->subject('Acesso liberado ao curso ' . $this->course->title)
                    ->markdown('emails.access-granted');
    }
}
