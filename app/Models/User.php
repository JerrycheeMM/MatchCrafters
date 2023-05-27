<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_USER = 'USER';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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
    ];

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function prefunds()
    {
        return $this->hasMany(Prefund::class, 'prefund_user_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'merchant_user_id');
    }


    public function logoutEverywhere($includingSelf = true)
    {
        if ($includingSelf) {
            $tokens = $this->tokens->pluck('id');
        } else {
            $latestTokenId = $this->tokens()->latest()->first()->id;
            $tokens = $this->tokens->whereNotIn('id', $latestTokenId)->pluck('id');
        }

        Token::whereIn('id', $tokens)
            ->update(['revoked' => true]);

        RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);
    }
}
