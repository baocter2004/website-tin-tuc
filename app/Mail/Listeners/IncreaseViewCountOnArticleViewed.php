<?php

namespace App\Listeners;

use App\Events\ArticleViewed;
use App\Jobs\IncrementViewCount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncreaseViewCountOnArticleViewed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ArticleViewed  $event
     * @return void
     */
    public function handle(ArticleViewed $event)
    {
        IncrementViewCount::dispatch($event->article);
    }
}
