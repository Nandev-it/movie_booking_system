<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    protected $fillable = [
        'name',
        'location',
        'image',
        'total_screens',
    ];

    public function screens()
    {
        return $this->hasMany(Screen::class);
    }
}
