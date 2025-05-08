<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', 
    ];

    public function isAdmin()
    {
        return $this->is_admin; // Returns true if the user is an admin
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function borrows(){
        return $this->hasMany(Borrow::class);
    }

    public function libraryCard(){
        return $this->hasOne(LibraryCard::class);
    }

    public function hasActiveLibraryCard(){
        $card = $this->libraryCard;

        if (!$card){
            return false;
        }
        return $card->isActive();
    }

    public function hasOutstandingFines(){
            return $this->borrows()->whereNull('returned_at')->where('due_date', '<', now())->exists();
        }

    public function totalFine(){
            return $this->borrows()->whereNull('returned_at')->where('due_date', '<', now())->get()->sum(function ($borrow) {
            return $borrow->calculateFine();
            });
        }
}
