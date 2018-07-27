<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeatMap extends Model
{   
    public $timestamps = false;
   public static function getSeatMap($search,$page)
   {
    $search = str_replace('%','\%',$search);
    $search = str_replace('_','\_',$search);
    $maps = self::offset($page-1)
                ->where('name','like',"%$search%")
                ->limit(8)
                ->get();
    return $maps;
   }


    public function users()
    {
        return  $this->belongsToMany('App\User', 'user_seats')->withPivot('X', 'Y');
    }
    
    public static function getMapWithUsers( int $id ) {
        return self::with( 'users' )->where( 'id', $id )->first();
    }
}
