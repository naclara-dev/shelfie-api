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
        'password',
        'role'
    ];

    protected $hidden = [
        'password'
    ];

    /**
     * Hashes the password on saving.
     * @param string $value
     */
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Checks if the user has admin privileges.
     */
    public function isAdmin() {
        return $this->role->name === 'admin';
    }    

    /*
    |-------------------
    | RELATIONSHIPS
    |-------------------
    */
    public function ratings() {
        return $this->hasMany(Rating::class);
    }    
    public function role() {
        return $this->belongsTo(Role::class);
    }
}
