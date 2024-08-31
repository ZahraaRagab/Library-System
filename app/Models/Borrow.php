<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'borrowed_at',
        'return_due_at',
        'returned_at',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'return_due_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    // Define relationships
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
