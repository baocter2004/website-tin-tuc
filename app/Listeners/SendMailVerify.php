<?php

namespace App\Listeners;

use App\Events\RegisterSuccessed;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailVerify implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public $user;
    public function __construct() {}

    /**
     * Handle the event.
     *
     * @param  \App\Events\RegisterSuccessed  $event
     * @return void
     */
    public function handle(RegisterSuccessed $event)
    {
        Mail::to($event->user->email)->send(new VerifyEmail($event->user));
        Log::info("Send mail success to user " . $event->user->email . " for verify");
    }
}
