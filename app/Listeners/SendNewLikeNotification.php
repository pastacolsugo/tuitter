<?php

namespace App\Listeners;

use \App\Events\NewLike;
use \App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewLikeNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewLike $event): void
    {
        $author = User::where('id', $event->post->author_id)->first();
        $author->notify(new \App\Notifications\NewLike($event->user, $event->post));
    }
}
