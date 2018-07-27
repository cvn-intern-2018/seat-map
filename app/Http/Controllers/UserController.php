<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
class UserController extends Controller
{
    /**
     * Load login form
     */
    public function getUsers()
    {
        $arr_users = [];
        $users = User::all();

        foreach ($users as $user) {
            $u = [];
            $u['name'] = $user->name;
            $u['email'] = $user->email;
            $arr_users[ $user->id] = json_encode($u);
        }
        // var_dump(json_encode($arr_users));exit;
        $param = [
            'users' => $users,
            'userj' => $arr_users,
        ];

        return view('user-setting', $param);
    }

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
        $this->validate($request, [
            'q' => 'required',
        ]);

        $name = trim($request->q);

        $user = new User();
        $user->name = $name;
        $user->password = 123;
        $user->username = "lelelele";
        $user->short_name = "lele";
        $user->phone = 123;
        $user->save();

        $status = [
            'status' => 'success',
            'data'  => $user
        ];
         return json_encode($status);
    }

    /**
     * Handle edit user request submit
     */
    public function editUserHandler( Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);

        $email = trim($request->email);

        $user = User::find(10);
        $user->email = $email;
        $user->save();

        $status = [
            'status' => 'success',
            'data'  => $user
        ];

        return redirect('/users');

    }

    /**
     * Handle delete user request submit
     */
    public function deleteUserHandler( Request $request)
    {
        return 'Handle delete user request';
    }

}
