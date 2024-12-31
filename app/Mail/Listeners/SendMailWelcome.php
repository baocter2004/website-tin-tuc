<?php

namespace App\Listeners;

use App\Events\RegisterSuccessed;
use App\Mail\VerifyEmail;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailWelcome implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Handle the event.
     *
     * @param  \App\Events\RegisterSuccessed  $event
     * @return void
     */
    public function handle(RegisterSuccessed $event)
    {
        try {
            Mail::to($event->user->email)->send(new WelcomeEmail($event->user));

            Log::info("Sent welcome email to: " . $event->user->email);
        } catch (\Exception $e) {
            Log::error('Error sending welcome email to ' . $event->user->email . ': ' . $e->getMessage());
            session()->flash('error', 'Có lỗi xảy ra khi gửi email chào mừng. Vui lòng thử lại sau.');
            return;
        }
    }
}
