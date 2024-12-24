<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    // Khai báo biến chứa đối tượng User
    public $user;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Chào mừng bạn đến với nền tảng của chúng tôi!')
                    ->view('auth.emails.welcome')
                    ->with([
                        'firstName' => $this->user->first_name,
                        'lastName' => $this->user->last_name,
                        'email' => $this->user->email,
                    ]);
    }
}
