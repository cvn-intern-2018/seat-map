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
    public static function addSeatMap($name)
    {

        $id = self::insertGetId(
            ['name' => $name]
        );
        return $id;
    }

    public static function deleteSeatMap($id)
    {
        self::where('id', $id)->delete();
        return;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_seats')->withPivot('X', 'Y');
    }

    /**
     * Get map image file by map ID
     *
     * @param int $id
     * @return string|null
     */
    public static function getMapImage(int $id)
    {
        if (Storage::disk('public_folder')->exists('images/seat-map/' . $id . '.jpg')) {
            return asset('images/seat-map/' . $id . '.jpg');
        } elseif (Storage::disk('public_folder')->exists('images/seat-map/' . $id . '.jpeg')) {
            return asset('images/seat-map/' . $id . '.jpeg');
        } elseif (Storage::disk('public_folder')->exists('images/seat-map/' . $id . '.png')) {
            return asset('images/seat-map/' . $id . '.png');
        } elseif (Storage::disk('public_folder')->exists('images/seat-map/' . $id . '.bmp')) {
            return asset('images/seat-map/' . $id . '.bmp');
        } elseif (Storage::disk('public_folder')->exists('images/seat-map/' . $id . '.gif')) {
            return asset('images/seat-map/' . $id . '.gif');
        }
        return null;
    }
}
