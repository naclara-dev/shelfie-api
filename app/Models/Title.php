<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $table = 'titles';

    protected $fillable = [
        'name',
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
        return $this->belongsToMany(Genre::class, 'genre_title', 'title_id', 'genre_id');
    }
    public function ratings() {
        return $this->hasMany(Rating::class, 'title_id');
    }
    public function type() {
        return $this->belongsTo(Type::class, 'type');
    }
}
