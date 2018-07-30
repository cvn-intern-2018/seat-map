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
    public function addSeatmapHandler(Request $request)
    {
        if ($request->user()->permission==1) {
            $id = Map::addSeatMap($request->name);
            $public = Storage::disk('public_folder');
            $f = $request->file('pic');
            $public->putFileAs('images/seat-map', $f, $id.'.' .  $f->extension());
            return redirect()->route('home');
        } else {
            return "Bạn không có quyền ADD!!!";
        }
    }

    /**
     * Delete seat map
     */
    public function deleteSeatmapHandler(Request $request)
    {
        if ($request->user()->permission==1) {
            $id = $request->id;
            Map::deleteSeatMap($id);
            return "Đã Xóa";
        } else {
            return "Bạn không có quyền Delete!!!";
        }
    }

    /**
     * Load add seat map page
     */
    public function getEditSeatmapPage(int $id)
    {
        $map = Map::getMapWithUsers($id);
        $map_image = Map::getMapImage($id);
        $users = User::getAllUsersWithGroup();
        $avatars = User::getUserAvatar($users);
        return view('seat-map/edit-seat-map', [
            'map' => $map,
            'arranged_users' => $map->users,
            'arranged_ids' => $map->users->keyBy('id')->keys()->toArray(),
            'users' => $users,
            'avatars' => $avatars,
            'map_image' => $map_image,
            'edit_mode' => true,
        ]);
    }
    
    /**
     * Handle edit Seatmap request submit
     */
    public function editSeatmapHandler(Request $request)
    {
        return 'Handle edit Seatmap request';
    }
}
