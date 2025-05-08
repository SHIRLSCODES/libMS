<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrow;
use Illuminate\Support\Facades\Mail;
use App\Mail\DueDateReminder;
use Carbon\Carbon;

class SendDueDateReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send-due-date-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for books due soon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $borrows = Borrow::with('user', 'book')->whereNotNull('due_date')->whereNull('returned_at')->get();

        foreach ($borrows as $borrow) {
          $daysLeft = Carbon::now()->diffInDays(Carbon::parse($borrow->due_date), false);

                if ($daysLeft <= 3 && $daysLeft >= 0) {
                    Mail::to($borrow->user->email)->send(new DueDateReminder($borrow, 'due'));
                }
                if ($daysLeft < 0) {
                    $fine = 100 + abs($daysLeft) * 100;

                    $borrow->update(['fine_amount' => $fine, 'fine_paid' => false]);
                     
                    Mail::to($borrow->user->email)->send(new DueDateReminder($borrow, 'overdue', $fine));
                }
            }

    $this->info('Reminders sent to users whose books are due in 3 days or less.');
    }
}

