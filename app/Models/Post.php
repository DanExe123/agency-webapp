<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'description',
        'requirements',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->with('user.profile')
                    ->where($field ?? $this->getRouteKeyName(), $value)
                    ->firstOrFail();
    }

    public function company()
        {
            return $this->belongsTo(Company::class);
        }

    public function responses()
    {
        return $this->hasMany(PostResponse::class);
    }

    public function guardNeeds()
    {
        return $this->hasMany(PostGuardNeed::class)->with('guardType');
    }


}
