<?php

namespace App\Listeners;

use App\Events\BookBorrowed;
use App\Jobs\SendBorrowNotificationJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBorrowNotification
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
    public function handle(BookBorrowed $event): void
    {
        SendBorrowNotificationJob::dispatch($event->user, $event->book);
    }
}
