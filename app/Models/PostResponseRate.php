<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostResponseRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_response_id',
        'guard_type_id',
        'proposed_rate',
    ];

    public function response()
    {
        return $this->belongsTo(PostResponse::class, 'post_response_id');
    }

    public function guardType()
    {
        return $this->belongsTo(SecurityGuardType::class);
    }
}
