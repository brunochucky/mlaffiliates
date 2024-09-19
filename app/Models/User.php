<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'affiliate_code',
        'cellphone',
        'referrer_id',
        'conversion',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
     * Boot method to automatically generate unique_rid when creating or updating a user.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate unique_rid when the user is created
        static::creating(function ($user) {
            if (empty($user->unique_rid)) {
                $user->unique_rid = md5($user->email); // Generate md5 hash based on the email
            }
        });
    }


    // Relationship to track the user who referred the current user
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    // Relationship to track the users referred by the current user (direct referrals)
    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id');
    }

    // Recursive relationship to get level 1 referrals
    public function levelOneReferrals()
    {
        return $this->referrals();
    }

    // Recursive relationship to get level 2 referrals
    public function levelTwoReferrals()
    {
        return $this->referrals()->with('levelOneReferrals');
    }

    // Recursive relationship to get level 3 referrals
    public function levelThreeReferrals()
    {
        return $this->referrals()->with('levelTwoReferrals');
    }

    // Recursive relationship to get level 4 referrals
    public function levelFourReferrals()
    {
        return $this->referrals()->with('levelThreeReferrals');
    }
}
