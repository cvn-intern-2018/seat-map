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
        $validated_data = $request->validate([
            'group_name' => 'required|max:100|unique:user_groups,name|string'
        ]);
        $new_id = Group::addNewGroup($validated_data['group_name']);
        return redirect()->route('groupSetting')->with([
            'active_group' => $new_id
        ]);
    }

    /**
     * Handle edit group request submit
     */
    public function editGroupHandler(Request $request)
    {
        $validated_data = $request->validate([
            'group_id' => 'required|int',
            'group_name' => 'required|max:100|string'
        ]);
        $group = Group::find($validated_data['group_id']);
        if ($group->updateGroupName($validated_data['group_name'])) {
            return json_encode(['result' => true]);
        }
        return json_encode([
            'result' => false,
            'message' => __('validation.unique', [
                'attribute' => 'group name'
            ]),
        ]);
    }

    public function updateUserGroupHandler(Request $request)
    {
        $validated_data = $request->validate([
            'user_group_id' => 'required|int',
            'user_group_data' => 'required|json',
        ]);
        $data = json_decode($validated_data['user_group_data']);
        User::updateUserGroup($validated_data['user_group_id'], $data->add, $data->remove);
        return redirect()->route('groupSetting')->with([
            'active_group' => $validated_data['user_group_id']
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
