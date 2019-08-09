<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Constraint\ExceptionCode;
use Mockery\Exception;

class User extends Authenticatable
{
    use Notifiable;
    protected $guarded = [];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function name(): HasOne
    {
        return $this->hasOne(Name::class);
    }


    /**
     * Get all phones that user has
     *
     * @return HasMany
     */
    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    /**
     * Get all emails that user has
     *
     * @return HasMany
     */
    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }

    /**
     * Get all addresses that user has
     *
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }


    public function getPrimary(string $type): Model
    {
        try {
            return $type->where('is_primary', true)->first();
        } catch (\Throwable $th) {
            throw new \Exception("$type model doesn not contain is_primary column");
        }
    }
}