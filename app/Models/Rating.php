<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'created_by',
        'title_id',
        'rating',
        'comment'
    ];

    protected $with = ['title', 'user'];

    /*
    |-------------------
    | RELATIONSHIPS
    |-------------------
    */  
    public function title() {
        return $this->belongsTo(Title::class, 'title_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
