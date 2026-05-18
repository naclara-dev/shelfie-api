<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
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
        return $this->belongsToMany(Title::class, 'genre_title', 'genre_id', 'title_id');
    }
}
