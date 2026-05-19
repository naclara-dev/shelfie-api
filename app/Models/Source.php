<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = 'sources';

    public $timestamps = false;

    protected $with = [
        'media',
    ];

    protected $fillable = [
        'name',
        'media_id',
    ];

    /*
    |-------------------
    | RELATIONSHIPS
    |-------------------
    */
    public function titleIdentifiers()
    {
        return $this->hasMany(TitleIdentifier::class, 'source_id');
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function titles()
    {
        return $this->belongsToMany(Title::class, 'title_identifiers', 'source_id', 'title_id');
    }
}
