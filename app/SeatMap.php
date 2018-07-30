<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

/**
 * Class SeatMap
 * @package App
 */
class SeatMap extends Model
{
    public $timestamps = false;

    /**
     * Get seat map with pagination
     * @param string $search
     * @param int $page
     * @return mixed
     */
    public static function getSeatMap(string $search,int $page)
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
     * Add a seat map to database
     * @param string $name
     * @return mixed
     */
    public static function addSeatMap(string $name)
    {

        $id = self::insertGetId(
            ['name' => $name]
        );
        return $id;
    }

    /**
     * delete a seat map by id
     * @param int $id
     */
    public static function deleteSeatMap(int $id)
    {
        self::where('id', $id)->delete();
        return;
    }

    /**
     * Add constraint property users to App\SeatMap
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_seats')->withPivot('X', 'Y');
    }

    public static function getMapWithUsers(int $id)
    {
        return self::with('users.group')->where('id', $id)->first();
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
