<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens;

    protected $fillable = [
        'username',
        'email',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    public function ratings() {
        return $this->hasMany(Rating::class);
    }
}
