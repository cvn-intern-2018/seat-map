<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeatMap extends Model
{

    public function users()
    {
        return  $this->belongsToMany('App\User', 'user_seats')->withPivot('X', 'Y');
    }
    
    public static function getMapWithUsers( int $id ) {
        return self::with( 'users' )->where( 'id', $id )->first();
    }
}
