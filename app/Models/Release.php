<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    protected $fillable = [
        'title',
        'description',
        'release_date',
        'poster',
        'genre',
        'status',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];
}
