<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class SeatMap extends Model
{
    public $timestamps = false;

    /**
     * get seat maps list with pagination
     * @param $search
     * @param $page
     * @return mixed
     */
    public static function getSeatMap($search, $page)
    {
        if ($search) {
            $search = str_replace('%', "/%", $search);
            $search = str_replace('_', "/_", $search);
            $maps = self::where('name', 'like', "%$search%")->orderBy('id', 'desc')->paginate(8);
            return $maps;
        } else {

            $maps = self::orderBy('id', 'desc')->paginate(8);
            return $maps;
        }
    }

    /**
     * add an seat map to database
     * @param $name
     * @return mixed
     */
    public static function addSeatMap($name, $img)
    {

        $id = self::insertGetId(
            ['name' => $name, 'img' => $img]
        );
        return $id;
    }

    public static function deleteSeatMap($id)
    {
        self::where('id', $id)->delete();
        return;
    }


    /**
     * Create connection to App\User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_seats')->withPivot('X', 'Y');
    }

    /**
     * Save seat map name
     *
     * @param string $newName
     * @return void
     */
    public function saveSeatMapName(string $newName)
    {
        $this->name = $newName;
        $this->save();
    }
}
