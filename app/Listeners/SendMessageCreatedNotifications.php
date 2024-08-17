<?php

namespace App\Listeners;

use App\Events\MessageCreated;
use App\Models\User;
use App\Notifications\NewMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMessageCreatedNotifications implements ShouldQueue
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
    public function handle(MessageCreated $event): void
    {
        // TODO: don't send yet
        // foreach (User::whereNot('id', $event->message->user_id)->cursor() as $user) {
        //     $user->notify(new NewMessage($event->message));
        // }
    }
}
