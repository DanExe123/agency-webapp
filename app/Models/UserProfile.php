<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $casts = [
    'year_established' => 'date', // now it will be a Carbon instance
];


    protected $fillable = [
        'user_id',
        'about_us',
        'logo_path',
        'bpl_path',
        'dti_path',
        'organization_type',
        'industry_type',
        'team_size',
        'year_established',
        'website',
        'vision',
        'address',
        'phone',
        'is_verified',
        'logo_original_name',
        'bpl_original_name',
        'dti_original_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
