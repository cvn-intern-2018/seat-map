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
     * Load detail seat map page
     * @param int $id
     * @return detail view
     */
    public function getSeatmapDetail(int $id)
    {
        $map = Map::with('users.group')->findOrFail($id);
        return view('detail', [
            'map' => $map,
            'users' => $map->users
        ]);
    }

    /**
     *  'Add Seatmap' request handler
     * @param Request $request
     * @return  redirect to the home view or back to the last view
     */
    public function addSeatmapHandler(Request $request)
    {
        $request->validate([
            'SeatmapPic' => 'max:5120 | required | dimensions:min_width=300,min_height=300',
            'SeatmapName' => 'required| max:100| string'
        ]);
        if ($request->user()->permission == 1) {
            $file = $request->file('SeatmapPic');
            $img = '.' . $file->extension();
            $id = Map::addSeatMap($request->SeatmapName, $img);
            $public = Storage::disk('public_folder');
            $public->putFileAs('images/seat-map', $file, $id . $img);
            $addSeatmapNoti = $request->SeatmapName . Lang::get('notification.added');
            $notifications = [$addSeatmapNoti];
            return redirect()->route('home')->with(['notifications' => $notifications]);
        } else {
            $permissionNoti = Lang::get('validation.permission');
            return back()->with(['notifications' => $permissionNoti]);
        }


    }

    /**
     * 'Delete Seatmap' request handler
     * @param Request $request
     * @return redirect to home view or back to the last view
     */
    public function deleteSeatmapHandler(Request $request)
    {
        $request->validate([
            'SeatmapID' => 'required | integer | exists:seat_maps,id',
            'SeatmapName' => 'required| max:100| string'
        ]);

        if ($request->user()->permission == 1) {
            $id = $request->SeatmapID;
            $name = $request->SeatmapName;
            Map::deleteSeatMap($id);
            $deletedSeatmapNoti = $name . Lang::get('notification.deleted');
            $notifications = [$deletedSeatmapNoti];
            if ($request->returnHome == 1)
                return redirect()->route('home')->with(['notifications' => $notifications]);
            else
                return back()->with(['notifications' => $notifications]);

        } else {
            $validateNoti = Lang::get('validation.permission');
            return back()->with(['notifications' => $validateNoti]);
        }


    }

    /**
     * Load add seat map page
     *
     * @param int $id
     * @return edit seat map view
     */
    public function getEditSeatmapPage(int $id)
    {
        $map = Map::with('users.group')->findOrFail($id);
        $arranged_ids = $map->users->keyBy('id')->keys()->toArray();
        $users = User::with('group')->whereNotIn('id', $arranged_ids)->get();
        $users = $map->users->merge($users);
        return view('seat-map/edit-seat-map', [
            'map' => $map,
            'arranged_ids' => $arranged_ids,
            'users' => $users,
            'edit_mode' => true,
        ]);
    }

    /**
     * Update new information and settings of seat map and user seats
     *
     * @param Request $request
     * @return view
     *
     * @throws Exception
     */
    public function updateEditingSeatmap(Request $request)
    {
        $validatedData = $request->validate([
            'seatmap_id' => 'required|integer|exists:seat_maps,id',
            'seatmap_name' => 'required|max:100',
            'seat_data' => 'nullable|json',
        ]);
        $seatmap_id = $validatedData['seatmap_id'];
        $user_seat = [];
        $user_ids = array_map(function($item) {
            return $item['id'];
        }, User::select('id')->get()->toArray());

        if (!empty($validatedData['seat_data'])) {
            $user_seat = array_map(function ($item) use ($seatmap_id) {
                $new_item = get_object_vars($item);
                $new_item['x'] = (int)($new_item['x'] * 100);
                $new_item['y'] = (int)($new_item['y'] * 100);
                $new_item['seat_map_id'] = $seatmap_id;
                if (($new_item['x'] > 10000) || ($new_item['x'] < 0) || ($new_item['y'] > 10000) || ($new_item['y'] < 0)) {
                    $validator = \Illuminate\Support\Facades\Validator::make([], []);
                    $validator->errors()->add('seat_data', 'Seat data is invalid');
                    throw new \Illuminate\Validation\ValidationException($validator);
                }
                return $new_item;
            }, json_decode($validatedData['seat_data']));
            $user_seat = array_filter($user_seat, function ($item) use ($user_ids) {
                return in_array($item['user_id'], $user_ids);
            });
        }

        // DB::beginTransaction();
        try {
            $map = Map::findOrFail($seatmap_id);
            $map->saveSeatMapName($validatedData['seatmap_name']);

            if (!empty($user_seat)) {
                Seat::updateUserSeat($seatmap_id, $user_seat);
            }
            // DB::commit();
            $editSeatmapNoti = $request->seatmap_name . Lang::get('notification.saved');
            $notifications = [$editSeatmapNoti];
            return redirect()->route('seatmapDetail', [
                'id' => $seatmap_id,
            ])->with(['notifications' => $notifications]);
        } catch (Exception $e) {
            // DB::rollback();
            throw $e;
        }
    }
}
