<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Load login form
     */
    public function getLoginView(Type $var = null)
    {
        return view('login');
    }
    
    /**
     * Handle logout request
     */
    public function logout() {
        if ( Auth::check() ) {
            Auth::logout();
        }
        return redirect('/');
    }

    /**
     * Load Add/Edit/Delete user page
     */
    public function getUserSettingView()
    {
        return 'User setting view';
    }

    /**
     * Handle add user request submit
     */
    public function addUserHandler( Request $request)
    {
        return 'Handle add user request';
    }

    /**
     * Handle edit user request submit
     */
    public function editUserHandler( Request $request)
    {
        return 'Handle edit user request';
        }

    /**
     * Handle delete user request submit
     */
    public function deleteUserHandler( Request $request)
    {
        return 'Handle delete user request';
    }

}
