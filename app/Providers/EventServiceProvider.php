<?php

namespace App\Providers;

use App\Events\ArticleViewed;
use App\Events\CommentStatusUpdate;
use App\Events\RegisterSuccessed;
use App\Listeners\IncreaseViewCountOnArticleViewed;
use App\Listeners\SendMailVerify;
use App\Listeners\SendMailWelcome;
use App\Listeners\UpdateCommentStatus;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        RegisterSuccessed::class => [
            SendMailWelcome::class,
            SendMailVerify::class
        ],

        ArticleViewed::class => [
            IncreaseViewCountOnArticleViewed::class
        ],

        CommentStatusUpdate::class => [
            UpdateCommentStatus::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
