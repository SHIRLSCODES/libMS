<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
    ];
    
  
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
