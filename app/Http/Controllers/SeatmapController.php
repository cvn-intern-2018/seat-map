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
        return view('home');
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
        if($request->user()->permission==1)
        {
            $id = Map::addSeatMap($request->name);
            $public = Storage::disk('public_folder');
            $f = $request->file('pic');
            $public->putFileAs('images/seat-map', $f, $id.'.' .  $f->extension());
            return "Đã ADD";
        }
        else 
        {
            return "Bạn không có quyền ADD!!!";
        }

     
    }

    // Delete seat map

    public function deleteSeatmapHandler( Request $request )
    {
        if($request->user()->permission==1)
        {
            $id = $request->id;
            Map::deleteSeatMap($id);
            return "Đã Xóa";
        }
        else 
        {
            return "Bạn không có quyền Delete!!!";
        }

     
    }
    /**
     * Load add seat map page
     */
    public function getEditSeatmapPage( int $id = 1 )
    {
        $map = Map::getMapWithUsers($id);
        $mapImage = Map::getMapImage($id);
        $users = User::getAllUsersWithGroup();
        $avatars = User::getUserAvatar($users);
        return view('seat-map/edit-seat-map', [
            'map' => $map,
            'arranged_users' => $map->users,
            'users' => $users,
            'avatars' => $avatars,
            'mapImage' => $mapImage,
        ]);
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
   

    public function test() {
        $id = 1;
        $map = Map::getMapWithUsers($id);
        $mapImage = Map::getMapImage($id);
        $avatars = User::getUserAvatar($map->users);
        return view( 'seat-map/map-viewport', [
            'map' => $map ,
            'avatars' => $avatars,
            'mapImage' => $mapImage,
        ] );
    }
}