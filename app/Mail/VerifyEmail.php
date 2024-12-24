<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $verificationUrl;
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->verificationUrl = route(
            'auth.verify',
            [
                'id' => $user->id,
                'hash' => sha1($user->email)
            ]
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Xác thực email của bạn')
            ->view('auth.emails.verification')
            ->with([
                'userName' => $this->user->last_name . " " . $this->user->first_name,
                'verificationUrl' => $this->verificationUrl,
            ]);
    }
}
