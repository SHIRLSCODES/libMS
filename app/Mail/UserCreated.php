<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user, public string $plainPassword)
    {
        
    }

    //put back envelope method
    
    public function build()
    {
        return $this->subject('Your Account Has Been Created')->view('mail.user-created')
                    ->with([
                        'user' => $this->user,
                        'password' => $this->plainPassword,
                    ]);
    }

    /**
     * 
     * 
     * \Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
