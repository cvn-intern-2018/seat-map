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
        $status = "success";

        foreach ($users as $user) {
            $u = [];
            $u['name'] = $user->name;
            $u['email'] = $user->email;
            $u['phone'] = $user->phone;
            $u['groupid'] = $user->group_id;
            $u['password'] = $user->password;
            $u['username'] = $user->username;
            $arr_users[$user->id] = json_encode($u);
        }
        // var_dump(json_encode($arr_users));exit;
        $param = [
            'users' => $users,
            'userj' => $arr_users,
            'status' => $status,
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
    public function logout()
    {
        if (Auth::check()) {
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
    public function addUserHandler(Request $request)
    {
        
        $status = [];
        $status['response'] = "Success";
        $user = new User();

        if(empty($request->fullname)){
            $status['fullname'] = "Fullname is required";
            $status['response'] = "Error";
        }else {
            $user->name = $request->name;
        }

        if(empty($request->username)){
            $status['username'] = "Username is required";
            $status['response'] = "Error";
        }else {
            $user->username = $request->username;
        }

        if(empty($request->email)){
            $status['email'] = "Email is required";
            $status['response'] = "Error";
        }else {
            $user->email = $request->email; 
        }

        if(empty($request->group_id)){
            $status['group_id'] = "Group is required";
            $status['response'] = "Error";
        }else {
            $user->group_id = $request->group_id; 
        }

        if(empty($request->password)){
            $status['password'] = "Password is required";
            $status['response'] = "Error";
        }else {
            $user->password = $request->password; 
        }



<<<<<<< HEAD
=======
        $user = new User();
        $user->name = $name;
        $user->password = 123;
        $user->username = "lelelele";
        $user->short_name = "lele";
        $user->phone = 123;
        $user->save();

        $status = [
            'status' => 'success',
            'data' => $user
        ];
>>>>>>> 96587114f5517af675452a2794d620973f83313c
        return json_encode($status);

        // return "status";
     }

    /**
     * Handle edit user request submit
     */
    public function editUserHandler(Request $request)
    {
        $status = [];
        $status['status'] = "Success";
        $user = new User();

        // check fullname
<<<<<<< HEAD
        if(empty($request->name)){
            $status['name'] = "Fullname is required";
=======
        if (empty($request->name)) {
            $status['name'] = "Full Name is required";
>>>>>>> 96587114f5517af675452a2794d620973f83313c
            $status['status'] = "Error";
        } else {
            $name = $request->name;
            if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                $status['name'] = "Only letters and white space allowed";
                $status['status'] = "Error";
            } else {

                $user->name = $name;
            }
        }

        // check username
        if (empty($request->username)) {
            $status['username'] = "Username is required";
            $status['status'] = "Error";
        } else {
            $username = $request->username;
            if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                $status['name'] = "Only letters and numbers allowed";
                $status['status'] = "Error";
            } else if (User::where('username', '=', $username)->count() > 1) {
                $status['username'] = "Existed";
            } else {
                $user->username = $username;
            }
        }

        // check phonenumber
        if (empty($request->phone)) {
            $status['phone'] = "Phone number is required";
        } else {
            $phone = $request->phone;
            if (!preg_match("/^[0-9]*/", $phone)) {
                $status['phone'] = "Only numbers allowed";
            } else {
                $user->phone = $phone;
            }
        }

        // check password
        if (empty($request->password)) {
            $status['password'] = "Password is required";
            $status['status'] = "Error";

        } else {
            $password = $request->password;
            if (!preg_match("/^[a-zA-Z0-9]*$/", $password)) {
                $status['password'] = "Only letters and numbers allowed";
                $status['status'] = "Error";
            } else {
                $user->password = $password;
            }
        }

        // check groupid
        if (empty($request->group_id)) {
            $status['group_id'] = "Group is required";
            $status['status'] = "Error";
        } else {
            $group_id = $request->group_id;
            $user->user_group_id = $group_id;
        }

        // check status
        if ($status['status'] == "Success") {
            $user->short_name = "";
            // delete
            User::where('username', '=', $username)->delete();
            // save
            $user->save();
        }

        return json_encode($status);
    }

    /**
     * Handle delete user request submit
     */
    public function deleteUserHandler(Request $request)
    {
        $status = [];
        $status['status'] = "successful";

        if (empty($request->name)) {

        } else {
            User::where('name', $request->name)->delete();

        }

        return json_encode($status);
    }

}
