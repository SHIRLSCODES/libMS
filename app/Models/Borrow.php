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
        'fine_amount',
        'fine_paid',
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

    public function calculateFine()
        {
            if (!$this->due_date || $this->returned_at || now()->lessThanOrEqualTo($this->due_date)) {
                return 0;
            }

            $daysOverdue = $this->due_date->diffInDays(now());

            return 100 + ($daysOverdue * 100);
        }
}
