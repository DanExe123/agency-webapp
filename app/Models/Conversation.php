<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
    'user_one',
    'user_two',
    'archived_by_user_one',
    'archived_by_user_two',
    'deleted_by_user_one',
    'deleted_by_user_two'
];


    // Messages relation
    public function messages()
    {
        return $this->hasMany(Mensahe::class, 'conversation_id');
    }

    // Last message relation
    public function lastMessage()
    {
        return $this->hasOne(Mensahe::class, 'conversation_id')->latest();
    }

    // User one relation
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one');
    }

    // User two relation
    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two');
    }
}

