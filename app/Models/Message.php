<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // ✅ Add the columns you want to be mass-assignable
    protected $fillable = [
        'sender_id',
        'receiver_id', // keep for future use, even if null for now
        'content',
    ];

    // Optional: define relationship to User
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
