<?php

namespace App\services;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'title',
        'video',
        'type'
    ];
}
