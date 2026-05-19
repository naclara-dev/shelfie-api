<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $table = 'titles';

    protected $fillable = [
        'created_by',
        'name',
        'media_id',
        'year',
    ];

    protected $with = [
        'genres',
        'media',
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
    public function media() {
        return $this->belongsTo(Media::class, 'media_id');
    }
    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function identifiers() {
        return $this->hasMany(TitleIdentifier::class, 'title_id');
    }

    /**
     * Temporary compatibility alias while the rest of the app is migrated from type to media.
     */
    public function type() {
        return $this->media();
    }
}
