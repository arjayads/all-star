<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\DB;

class AddRequestRepo {

    /**
     * @param $userData
     * @return static
     */
    public function findByRecipientUserId($userId)
    {
        $q = DB::table('add_requests')
            ->join('users', 'add_requests.requested_by_user_id', '=', 'users.id');
        return $q->where('add_requests.recipient_user_id', $userId)->select('users.name', 'add_requests.requested_by_user_id')->get();
    }

}