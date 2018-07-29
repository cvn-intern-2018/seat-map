<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
class SeatMap extends Model
{   
    public $timestamps = false;
   public static function getSeatMap($search,$page)
   {
    if($search){
       $search = str_replace('%',"/%",$search);
       $search = str_replace('_',"/_",$search);
    $maps = self::where('name','like',"%$search%")
    ->paginate(8);
    return $maps;
    }
    else
    {
        $maps = self::paginate(8)
        ;
        return $maps;
    }
   }


    public function users()
    {
        return  $this->belongsToMany('App\User', 'user_seats')->withPivot('X', 'Y');
    }
    
    public static function getMapWithUsers( int $id ) {
        return self::with( 'users' )->where( 'id', $id )->first();
    }
}
