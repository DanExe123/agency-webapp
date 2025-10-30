<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostGuardNeed extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'guard_type_id',
        'quantity',
    ];

    public function guardType()
    {
        return $this->belongsTo(SecurityGuardType::class);
    }
}
