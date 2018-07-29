<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

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
        return self::with( 'users.group' )->where( 'id', $id )->first();
    }

    public static function getMapImage(int $id)
    {
        if ( Storage::disk( 'public_folder' )->exists( 'images/seat-map/' . $id . '.jpg' ) ) {
            return asset( 'images/seat-map/' . $id . '.jpg');
        }
        elseif ( Storage::disk( 'public_folder' )->exists( 'images/seat-map/' . $id . '.png' ) ) {
            return asset( 'images/seat-map/' . $id . '.png');
        }
        elseif ( Storage::disk( 'public_folder' )->exists( 'images/seat-map/' . $id . '.bmp' ) ) {
            return asset( 'images/seat-map/' . $id . '.bmp');
        }
        elseif ( Storage::disk( 'public_folder' )->exists( 'images/seat-map/' . $id . '.gif' ) ) {
            return asset( 'images/seat-map/' . $id . '.gif');
        }
        return null;
    }
}
