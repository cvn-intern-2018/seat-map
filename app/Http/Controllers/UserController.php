<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserGroup;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public $response = [];
    public $userInforErr = [];
    public $userInfor = [];

    /**
     * Load login form
     */
    public function getUsers(Request $request)
    {
        $arr_users = [];
        $users = User::all();
        $groups = UserGroup::all();
        $admin = [];

        foreach ($users as $user) {
            if ($user->permission == 0) {
                $userInfor = [];
                $userInfor['id'] = $user->id;
                $userInfor['fullname'] = $user->name;
                $userInfor['avatar'] = $user->img;
                $userInfor['email'] = $user->email;
                $userInfor['phone'] = $user->phone;
                $userInfor['group'] = UserGroup::where('id', $user->user_group_id)->first()->name;
                $userInfor['password'] = $user->password;
                $userInfor['username'] = $user->username;
                $userInfor['short_name'] = $user->short_name;
                $arr_users[$user->id] = json_encode($userInfor);
            } else {
                $admin['id'] = $user->id;
                $admin['avatar'] = $user->img;
                $admin['fullname'] = $user->name;
                $admin['password'] = $user->password;
                $admin['email'] = $user->email;
                $admin['phone'] = $user->phone;
                $admin['group'] = UserGroup::where('id', $user->user_group_id)->first()->name;
                $admin['short_name'] = $user->short_name;
                $admin['username'] = $user->username;
            }
        }

        return view('user-setting', ['users' => $users,
            'arr_users' => $arr_users,
            'admin' => json_encode($admin),
            'groups' => $groups,
            'user_id' => $request->session('user_id', 1),
            'prv_data' => $request->session('prv_data', 1),
            'prv_error' => $request->session('prv_error', 1)
        ]);
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

    public function check_request($infor)
    {
        // check username
        if (empty($infor->username)) {
            $this->userInfor['username'] = "";
            $this->userInforErr['usernameErr'] = "Username is required";
        } else {
            $username = UserController::test_input($infor->username);
            $this->userInfor['username'] = $username;
            if (User::where('username', '=', $username)->count() > 0) {
                $this->userInforErr['usernameErr'] = "Existed";
            } else if (strlen($username) > 50) {
                $this->userInforErr['usernameErr'] = "The username may not be greater than 50 characters";
            }
        }

        // check fullname
        if (empty($infor->fullname)) {
            $this->userInfor['fullname'] = "";
            $this->userInforErr['fullnameErr'] = "Fullname is required";
        } else {
            $fullname = UserController::test_input($infor->fullname);
            $this->userInfor['fullname'] = $fullname;
            if (strlen($fullname) > 50) {
                $this->userInforErr['fullnameErr'] = "The fullname may not be greater than 50 characters";
            }
        }

        // check password        
        if (empty($infor->password)) {
            $this->userInfor['password'] = "";
            $this->userInforErr['passwordErr'] = "Password is required";
        } else {
            $password = UserController::test_input($infor->password);
            $this->userInfor['password'] = $password;
        }

        // check email
        if (empty($infor->email)) {
            $this->userInfor['email'] = "";
            $this->userInforErr['emailErr'] = "Email is required";
        } else {
            $email = UserController::test_input($infor->email);
            $this->userInfor['email'] = $email;
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->userInforErr['emailErr'] = "Invalid email format";
            } else if (User::where('email', '=', $email)->count() > 0) {
                $this->userInforErr['emailErr'] = "Existed";
            } else if (strlen($email) > 50) {
                $this->userInforErr['emailErr'] = "The email may not be greater than 50 characters";
            }
        }

        // check short_name
        if (empty($infor->short_name)) {
            $this->userInfor['short_name'] = "";
            // $this->userInforErr['shortnameErr'] = "Shortname is required";
        } else {
            $short_name = UserController::test_input($infor->short_name);
            $this->userInfor['short_name'] = $short_name;
            if (strlen($short_name) > 10) {
                $this->userInforErr['shortnameErr'] = "The shortname may not be greater than 10 characters";
            }
        }

        // check phonenumber
        if (empty($infor->phone)) {
            $this->userInfor['phone'] = "";
            $this->userInforErr['phoneErr'] = "Phonenumber is required";
        } else {
            $phone = UserController::test_input($infor->phone);
            $this->userInfor['phone'] = $phone;
            if (!preg_match("/^[0-9]*$/", $phone)) {

                $this->userInforErr['phoneErr'] = "Only numbers allowed";
            } else if (strlen($phone) > 30) {
                $this->userInforErr['phoneErr'] = "The phonenumber may not be greater than 30 characters";
            }
        }

        // check avatar
        if (empty($infor->avatar)) {
            $this->userInfor['checkAvatar'] = $infor->checkAvatar;
        } else {
            $this->userInfor['checkAvatar'] = 0;
            $file = $infor->file('avatar');
            $img = '.' . $file->extension();
            $public = Storage::disk('public_folder');
            $public->putFileAs('images/user', $file, $infor->user_id . $img);
            $avatar = UserController::test_input($img);
            $this->userInfor['avatar'] = $avatar;
        }

        // check group_id
        if (empty($infor->group_id)) {
            $this->userInfor['group_id'] = 0;
        } else {
            $group_id = UserController::test_input($infor->group_id);
            $this->userInfor['group_id'] = $group_id;
            if (!preg_match("/^[0-9]*$/", $group_id)) {
                $this->userInforErr['group_idErr'] = "Only numbers allowed";
            }
        }
    }

    /**
     * Handle add user request submit
     */
    public function addUserHandler(Request $request)
    {
        $user = new User();
        $this->check_request($request);
        // check status
        // var_dump($request->avatar); exit;
        if (count($this->userInforErr) == 0) {
            $this->response['status'] = "Success";
            $user->set($this->userInfor);
            $user->save();
        } else {
            $this->response['status'] = "Error";
        }
        // var_dump($this->userInfor); exit;
        $this->userInfor['id'] = $user->id;
        $this->response['userInfor'] = $this->userInfor;
        $this->response['userInforErr'] = $this->userInforErr;
        // var_dump($this->response); exit;
        return json_encode($this->response);
    }

    /**
     * Handle edit user request submit
     */
    public function editUserHandler(Request $request)
    {
        $prv_data = "";
        if (!empty($request->user_id)) {
            $user = User::where('id', $request->user_id)->first();
            $this->check_request($request);
            // $this->response['userInfor'] = $this->userInfor;
            // $this->response['userInforErr'] = $this->userInforErr;
            // var_dump($request->user_id);
            // var_dump($this->response); exit;
            if(($this->userInforErr['emailErr'] == "Existed") and ($user->email == $this->userInfor['email'])){
                unset($this->userInforErr['emailErr']);
            }
            if(!empty($request->username)){
                $this->userInforErr['usernameErr'] = "Not allowed!";   
            }
            if(!empty($request->password)){
                $this->userInforErr['passwordErr'] = "Not allowed!";   
            }
            // $this->response['userInfor'] = $this->userInfor;
            // $this->response['userInforErr'] = $this->userInforErr;
            // var_dump($this->response); exit;
            if (count($this->userInforErr) == 0) {
                $this->response['status'] = "Success";
                // var_dump($this->userInfor); exit;
                $user->set($this->userInfor);
                $user->save();
                return redirect()->route('users')->with(['user_id' => $request->user_id, 'prv_data' => '', 'prv_error' => '']);
            } else {
                $this->userInfor['id'] = $user->id;
                if ($this->userInfor['checkAvatar'] == 1) {
                    $this->userInfor['avatar'] = "";
                } else {
                    $this->userInfor['avatar'] = $user->img;
                }
                $this->response['status'] = "Error";
                return redirect()->route('users')->with(['user_id' => $request->user_id,
                    'prv_data' => json_encode($this->userInfor),
                    'prv_error' => $this->userInforErr]);
            }
        } else {
            return abort(404);
        }
        // $this->response['userInfor'] = $this->userInfor;
        // $this->response['userInforErr'] = $this->userInforErr;
        // return redirect()->route('users')->with(['user_id' => $request->user_id]);
    }

    /**
     * Handle delete user request submit
     */
    public function deleteUserHandler(Request $request)
    {

        if (empty($request->id)) {
            $this->response['status'] = "Error";
        } else {
            User::where('id', $request->id)->delete();
            // var_dump($request->id); exit;
            $this->response['status'] = "Success";
        }
        return json_encode($this->response);
    }

    public function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        // $data = htmlspecialchars($data);
        return $data;
    }

}

