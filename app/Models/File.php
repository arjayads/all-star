<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'original_filename',
        'new_filename',
        'mime_type'
    ];
}
