<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'about_us',
        'logo_path',
        'certificate_path',
        'valid_id_path',
        'organization_type',
        'industry_type',
        'team_size',
        'year_established',
        'website',
        'vision',
        'address',
        'phone',
        'email',
        'is_verified',
        'logo_original_name',
        'certificate_original_name',
        'valid_id_original_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
