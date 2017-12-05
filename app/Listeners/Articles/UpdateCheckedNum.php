<?php

namespace App\Listeners\Articles;

use App\Events\UpdateArticle;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateCheckedNum
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
     * @param  UpdateArticle  $event
     * @return void
     */
    public function handle(UpdateArticle $event)
    {
        $event->article->increment('checked_num');
    }
}
