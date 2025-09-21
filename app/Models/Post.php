<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'company_name',
        'logo',
        'featured',
        'website',
        'phone',
        'email',
        'description',
        'requirements',
        'location',
        'needs',
        'founded_in',
        'company_size',
    ];
}
