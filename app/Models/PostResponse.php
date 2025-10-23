<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'agency_id',
        'message',
        'proposed_rate',
        'status',
        'chat_id',
        'remarks',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function agency()
    {
        return $this->belongsTo(User::class, 'agency_id');
    }
}
