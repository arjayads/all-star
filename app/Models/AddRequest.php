<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddRequest extends Model
{
    protected $fillable = [
        'requested_by_user_id',
        'recipient_user_id'
    ];

    public $timestamps = false;
}
