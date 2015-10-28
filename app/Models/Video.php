<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'title',
        'upload_filename',
        'original_filename',
        'mime_type',
        'type',
        'category_id'
    ];
}
