<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitleIdentifier extends Model
{
    protected $table = 'title_identifiers';

    protected $fillable = [
        'title_id',
        'source_id',
        'value',
    ];

    /*
    |-------------------
    | RELATIONSHIPS
    |-------------------
    */
    public function title()
    {
        return $this->belongsTo(Title::class, 'title_id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
}
