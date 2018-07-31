<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    /**
     * Load Add/Edit/Delete group page
     */
    public function getGroupSettingView()
    {
        return 'Group setting view';
    }

    /**
     * Handle add group request submit
     */
    public function addGroupHandler(Request $request)
    {
        return 'Handle add group request';
    }

    /**
     * Handle edit group request submit
     */
    public function editGroupHandler(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);

        $post = User::find(1);
        $post->email = $request->email;
        $post->save();

        $status = [
            'status' => 'success',
            'data' => $post
        ];

        return json_encode($status);
    }

    /**
     * Handle delete group request submit
     */
    public function deleteGroupHandler(Request $request)
    {
        return 'Handle delete group request';
    }
}
