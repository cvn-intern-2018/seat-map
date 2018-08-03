<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserSeat extends Model
{
    /**
     * Delete all user seat on map with given ID and insert new list
     * 
     * @param int $map_id
     * @param int $new_data
     * @return void
     */
    public static function updateUserSeat(int $map_id, array $new_data)
    {
        self::where('seat_map_id', $map_id)->delete();
        self::insert($new_data);
    }
}
