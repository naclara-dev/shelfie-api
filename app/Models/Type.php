<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'name'
    ];

    /*
    |-------------------
    | RELATIONSHIPS
    |-------------------
    */    
    public function titles() {
        return $this->hasMany(Title::class, 'type');
    }
}
