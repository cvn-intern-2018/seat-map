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
    public function addGroupHandler( Request $request)
    {
        return 'Handle add group request';
    }

    /**
     * Handle edit group request submit
     */
    public function editGroupHandler( Request $request)
    {
        return 'Handle edit group request';
        }

    /**
     * Handle delete group request submit
     */
    public function deleteGroupHandler( Request $request)
    {
        return 'Handle delete group request';
    }
}
