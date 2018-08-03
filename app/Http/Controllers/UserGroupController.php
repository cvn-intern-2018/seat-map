<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserGroup as Group;

class UserGroupController extends Controller
{
    /**
     * Load Add/Edit/Delete group page
     */
    public function getGroupSettingView(Request $request)
    {
        $users = User::get();
        $groups = Group::get()->keyBy('id');
        $active_id = $request->session()->get('active_group', $groups->first()->id);
        $unassigned = $groups->pull(1);
        return view('group-setting', [
            'users' => $users,
            'groups' => $groups,
            'active_id' => $active_id,
            'unassigned_group' => $unassigned,
        ]);
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
        $validatedData = $request->validate([
            'group_id' => 'required|int',
            'group_name' => 'required|max:100|string'
        ]);
        $group = Group::find($validatedData['group_id']);
        if ($group->updateGroupName($validatedData['group_name'])) {
            return json_encode(['result' => true]);
        }
        return json_encode([
            'result' => false,
            'message' => __('validation.unique', [
                'attribute' => 'group name'
            ]),
        ]);
    }

    /**
     * Handle delete group request submit
     */
    public function deleteGroupHandler(Request $request)
    {
        return 'Handle delete group request';
    }
}
