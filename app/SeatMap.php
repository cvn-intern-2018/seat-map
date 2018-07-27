<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeatMap extends Model
{   
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
    public $timestamps = false;
}
