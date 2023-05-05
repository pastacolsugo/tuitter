<?php

namespace App\Listeners;

use App\Events\NewReply;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use \App\Models\User;
use \App\Models\Post;

class SendNewReplyNotification
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
    public function handle(NewReply $event): void
    {
        $author = User::where('id', $event->post->author_id)->first();
        $author->notify(new \App\Notifications\NewReply($event->user, $event->post));
    }
}
