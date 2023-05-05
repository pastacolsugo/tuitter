<?php

namespace App\Listeners;

use App\Events\NewFollow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewFollowNotification
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
    public function handle(NewFollow $event): void
    {
        $event->followee->notify(new \App\Notifications\NewFollow($event->follower, $event->followee));
    }
}
