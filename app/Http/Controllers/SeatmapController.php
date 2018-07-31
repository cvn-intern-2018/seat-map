<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Exception;
use App\SeatMap as Map;
use App\UserSeat as Seat;
use App\User;
use Lang;

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
     *  'Add Seatmap' request handler
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addSeatmapHandler(Request $request)
    {
        $request->validate([
            'SeatmapPic' => 'max:5120 | required | dimensions:min_width=300,min_height=300',
            'SeatmapName' => 'required| max:100| string'
        ]);
        if ($request->user()->permission == 1) {
            $id = Map::addSeatMap($request->SeatmapName);
            $public = Storage::disk('public_folder');
            $f = $request->file('SeatmapPic');
            $public->putFileAs('images/seat-map', $f, $id . '.' . $f->extension());
            $addSeatmapNoti = $request->SeatmapName . Lang::get('notification.added');
            $notifications = [$addSeatmapNoti];
            return back()->with(['notifications' => $notifications]);
        } else {
            return "update later";
        }


    }

    /**
     * 'Delete Seatmap' request handler
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function deleteSeatmapHandler(Request $request)
    {
        $request->validate([
            'SeatmapID' => 'required | interger',
            'SeatmapName' => 'required| max:100| string'
        ]);
        if ($request->user()->permission == 1) {
            $id = $request->SeatmapID;
            $name = $request->SeatmapName;
            Map::deleteSeatMap($id);
            $deletedSeatmapNoti = $name . Lang::get('notification.deleted');
            $notifications = [$deletedSeatmapNoti];
            return back()->with(['notifications' => $notifications]);

        } else {
            return "update later";
        }


    }

    /**
     * Load add seat map page
     */
    public function getEditSeatmapPage(int $id)
    {
        $map = Map::with('users.group')->findOrFail($id);
        $map_image = Map::getMapImage($id);
        $users = User::with('group')->get();
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
    public function updateEditingSeatmap(Request $request)
    {
        $validatedData = $request->validate([
            'seatmap_id' => 'required|integer',
            'seatmap_name' => 'required|max:100',
            'seat_data' => 'nullable|json',
        ]);

        DB::beginTransaction();
        try {
            $map = Map::findOrFail($validatedData['seatmap_id']);
            $map->name = $validatedData['seatmap_name'];
            $map->save();

            if (empty($validatedData['seat_data'])) {
                return redirect()->route('seatmapDetail', [
                    'id' => $validatedData['seatmap_id'],
                ]);
            } else {
                $user_seat = array_map(function ($item) use ($validatedData) {
                    $new_item = get_object_vars($item);
                    $new_item['x'] = (int)($new_item['x'] * 100);
                    $new_item['y'] = (int)($new_item['y'] * 100);
                    $new_item['seat_map_id'] = $validatedData['seatmap_id'];
                    return $new_item;
                }, json_decode($validatedData['seat_data']));
                Seat::where('seat_map_id', $validatedData['seatmap_id'])->delete();
                Seat::insert($user_seat);
            }
            DB::commit();
            return redirect()->route('seatmapDetail', [
                'id' => $validatedData['seatmap_id'],
            ]);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
