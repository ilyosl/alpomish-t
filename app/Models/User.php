<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Leeto\PhoneAuth\Casts\PhoneCast;
use Leeto\PhoneAuth\Models\Traits\PhoneVerification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, PhoneVerification;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'username',
        'phone',
        'phone_verified',
        'phone_verified_at',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified'=> 'boolean',
        'phone_verified_at'=> 'datetime',
        'phone'=> PhoneCast::class
    ];

    public function messages():HasMany
    {
        return $this->hasMany(Message::class);
    }
}
