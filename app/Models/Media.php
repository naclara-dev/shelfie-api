<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'name'
    ];

    /*
    |-------------------
    | RELATIONSHIPS
    |-------------------
    */    
    public function titles() {
        return $this->hasMany(Title::class, 'media_id');
    }
}
