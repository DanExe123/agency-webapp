<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use Carbon\Carbon;


/**
 * App\Models\User
 *
 * 
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'account_status',
        'rejection_feedback',
        'rating',
        'is_read',
        'payment_method',      
        'payment_proof_path', 
        'subscription_plan',   
        'subscription_price',    
    ];
    protected $casts = [
        'is_read' => 'boolean',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

     protected $dates = [
        'subscription_start',
        'subscription_end',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function postResponses()
    {
        return $this->hasMany(PostResponse::class, 'agency_id');
    }

    // Relation to Feedback received
    public function feedbacksReceived()
    {
        return $this->hasMany(Feedback::class, 'receiver_id');
    }

    // Function to get average rating
    public function averageRating()
    {
        return round($this->feedbacksReceived()->avg('rating') ?? 0, 2);
    }

    // Function to get total feedback count
    public function feedbackCount()
    {
        return $this->feedbacksReceived()->count();
    }
    
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function hasActiveSubscription(): bool
    {
        if (!$this->subscription_start || !$this->subscription_end) {
            return false;
        }

        return Carbon::now()->between(
            $this->subscription_start,
            $this->subscription_end
        );
    }

    //may uopdate ko di sa middleware ka subscription 

    /**
     
    */


}
