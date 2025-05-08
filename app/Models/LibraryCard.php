<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryCard extends Model
{
    protected $fillable = [
    'user_id',
     'issued_at', 
     'expires_at'
    ];

    protected $casts = [
        'issued_at'  => 'datetime',
        'expires_at' => 'datetime',
    ];    

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function isActive(){
        return $this->expires_at->isFuture() || $this->expires_at->equalTo(now());
    }
}
