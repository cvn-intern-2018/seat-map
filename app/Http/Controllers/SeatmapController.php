<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\SeatMap as Map;
use App\UserSeat as Seat;
use App\User;

class SeatmapController extends Controller
{
    /**
     * Load homepage
     */
    public function index()
    {
        return view('welcome');
    }
    /**
     * Load detail page
     */
    public function detail(int $seatmap_id)
    {
        return 'Detail page.';
    }
    /**
     * Load add seat map page
     */
    public function getAddSeatmapPage()
    {
        return view('seat-map/add-seat-map');
    }

    /**
     * Handle add Seatmap request submit
     */
    public function addSeatmapHandler( Request $request )
    {
        $public = Storage::disk('public_folder');
        $f = $request->file('seatmap_img');
        return $public->putFileAs('images/seat-map', $f, 't1.' .  $f->extension());
    }

    /**
     * Load add seat map page
     */
    public function getEditSeatmapPage()
    {
        return 'Load edit seat map page';
    }
    
    /**
     * Handle edit Seatmap request submit
     */
    public function editSeatmapHandler( Request $request)
    {
        return 'Handle edit Seatmap request';
    }

    /**
     * Handle delete Seatmap request submit
     */
    public function deleteSeatmapHandler( Request $request)
    {
        return 'Handle delete Seatmap request';
    }

    public function test() {
        $map = Map::getMapWithUsers(1);
        $avatars = [];
        foreach ($map->users as $user ) {
            if ( Storage::disk( 'public_folder' )->exists( 'images/user/' . $user->id . '.jpg' ) ) {
                $avatars[ $user->id ] = asset( 'images/user/' . $user->id . '.jpg');
            }
            elseif ( Storage::disk( 'public_folder' )->exists( 'images/user/' . $user->id . '.png' ) ) {
                $avatars[ $user->id ] = asset( 'images/user/' . $user->id . '.png');
            }
            elseif ( Storage::disk( 'public_folder' )->exists( 'images/user/' . $user->id . '.bmp' ) ) {
                $avatars[ $user->id ] = asset( 'images/user/' . $user->id . '.bmp');
            }
            elseif ( Storage::disk( 'public_folder' )->exists( 'images/user/' . $user->id . '.gif' ) ) {
                $avatars[ $user->id ] = asset( 'images/user/' . $user->id . '.gif');
            }
            else {
                $avatars[ $user->id ] = asset( 'images/user/mys-man.jpg');
            }
        }
        return view( 'seat-map/map-viewport', [
            'map' => $map ,
            'avatars' => $avatars,
        ] );
    }
}
