<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'role',
        'status',
        'main_wallet',
        'payin_wallet',
        'payout_wallet',
        'email_otp',
        'email_otp_expire_at',
        'email_verified_at',
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


    public function getWalletSummaryAttribute()
    {
        if ($this->role === 'admin') {
            return [
                'main_wallet'   => (float) User::where('role', 'user')->sum('main_wallet'),
                'payin_wallet'  => (float) User::where('role', 'user')->sum('payin_wallet'),
                'payout_wallet' => (float) User::where('role', 'user')->sum('payout_wallet'),
            ];
        }

        return [
            'main_wallet'   => (float) ($this->main_wallet ?? 0),
            'payin_wallet'  => (float) ($this->payin_wallet ?? 0),
            'payout_wallet' => (float) ($this->payout_wallet ?? 0),
        ];
    }
}
