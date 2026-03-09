<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'title',
        'type',
        'year'
    ];

    public function gender() {
        return $this->belongsToMany(Gender::class);
    }
}
