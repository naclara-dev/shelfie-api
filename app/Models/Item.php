<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'title',
        'type',
        'year',
        'genre',
        'imdb_id'
    ];

    protected $with = [
        'genres',
        'type'
    ];

    /*
    |-------------------
    | RELATIONSHIPS
    |-------------------
    */  
    public function genres() {
        return $this->belongsToMany(Genre::class);
    }
    public function ratings() {
        return $this->hasMany(Rating::class);
    }
    public function type() {
        return $this->belongsTo(Type::class, 'type');
    }
}
