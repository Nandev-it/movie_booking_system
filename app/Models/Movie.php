<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'description',
        'poster',
        'video_url', // add this
        'genre',
        'duration',
        'release_date'
    ];
}
