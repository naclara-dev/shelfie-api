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

    protected $with = ['genres'];

    public function genres() {
        return $this->belongsToMany(Genre::class);
    }
}
