<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Book;
use App\Mail\BookBorrowedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendBorrowNotificationJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user,public Book $book)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admin = User::where('is_admin', true)->orderBy('id')->first();

        if ($admin) {
            Mail::to($admin->email)->send(new BookBorrowedMail($this->user, $this->book));
        }
    }
}
