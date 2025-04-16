<?php

namespace App\Listeners;

use App\Events\UserWasCreated;
use App\Mail\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailToUser
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
    public function handle(UserWasCreated $event): void
    {
        $user = $event->user;
        $plainPassword = $event->plainPassword;

        Mail::to($user->email)->send(new UserCreated($user, $plainPassword));
    }
}
