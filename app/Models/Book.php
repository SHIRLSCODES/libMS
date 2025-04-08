<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function borrows(){
        return $this->hasMany(Borrow::class);
    }

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'copies',
        'is_archived',
        'category_id',
        'created_by',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
