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
            if($user->permission == 0){
                $userInfor = [];
                $userInfor['id'] = $user->id;
                $userInfor['fullname'] = $user->name;
                $userInfor['avatar'] = $user->img;
                $userInfor['email'] = $user->email;
                $userInfor['phone'] = $user->phone;
                $userInfor['group'] = UserGroup::where('id', $user->user_group_id)->first()->name;
                $userInfor['password'] = $user->password;
                $userInfor['username'] = $user->username;
                $userInfor['shortname'] = $user->short_name;
                $arr_users[$user->id] = json_encode($userInfor);
            }else{
                $admin['id'] = $user->id;
                $admin['avatar'] = $user->img;
                $admin['fullname'] = $user->name;
                $admin['password'] = $user->password;
                $admin['email'] = $user->email;
                $admin['phone'] = $user->phone;
                $admin['group'] = UserGroup::where('id', $user->user_group_id)->first()->name;
                $admin['shortname'] = $user->short_name;
                $admin['username'] = $user->username;
            }
        }

        return view('user-setting', [  'users' => $users,
            'userj' => $arr_users,
            'admin' => json_encode($admin),
            'groups' => $groups,
            'user_id' => $request->session('user_id', 1),
            'old' => $request->session('old', 1),
            'uv'  => $request->session('uv', 1)
            // 'abc' => "abc"
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

    public function check_request($infor){
        // check username
        if(empty($infor->username)){
            $this->userInfor['username'] = "";
            $this->userInforErr['usernameErr'] = "Username is required";
        }else{
            $username = UserController::test_input($infor->username);
             $this->userInfor['username'] = $username;
            if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                $this->userInforErr['usernameErr'] = "Only letters and numbers allowed";
            } else if (User::where('username', '=', $username)->count() > 0) {
                $this->userInforErr['usernameErr'] = "Existed";
            }
        }
        // check fullname
        if(empty($infor->fullname)){
            $this->userInfor['fullname'] = "";
            $this->userInforErr['fullnameErr'] = "Fullname is required";
        }else{
            $fullname = UserController::test_input($infor->fullname);
             $this->userInfor['fullname'] = $fullname;
            // if (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
            //     $this->userInforErr['fullnameErr'] = "Only letters and white space allowed";
            // }
        }
        // check password        
        if(empty($infor->password)){
            $this->userInfor['password'] = "";
            $this->userInforErr['passwordErr'] = "Password is required";
        }else{
            $password = UserController::test_input($infor->password);
             $this->userInfor['password'] = $password;
            // if (!preg_match("/^[a-zA-Z0-9]*$/", $password)) {
            //     $userInforErr['passwordErr'] = "Only letters and numbers allowed";
            // }            
        }
        // check email
        if(empty($infor->email)){
            $this->userInfor['email'] = "";
            $this->userInforErr['emailErr'] = "Email is required";
        }else{
            $email = UserController::test_input($infor->email);
             $this->userInfor['email'] = $email;
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $this->userInforErr['emailErr'] = "Invalid email format";
            }else if (User::where('email', '=', $email)->count() > 0) {
                $this->userInforErr['emailErr'] = "Existed";
            }           
        }
        // check short_name
        if(empty($infor->short_name)){
            $this->userInfor['shortname'] = "";
            // $this->userInforErr['shortnameErr'] = "Shortname is required";
        }else{
            $short_name = UserController::test_input($infor->short_name);
             $this->userInfor['shortname'] = $short_name;
            // if (!preg_match("/^[a-zA-Z]*$/", $short_name)) {
            //     $this->userInforErr['shortnameErr'] = "Only letters and white space allowed";
            // }            
        }
        // check phonenumber
        if(empty($infor->phone)){
            $this->userInfor['phone'] = "";
            $this->userInforErr['phoneErr'] = "Phonenumber is required";
        }else{
            $phone = UserController::test_input($infor->phone);
             $this->userInfor['phone'] = $phone;
            if (!preg_match("/^[0-9]*$/", $phone)) {

                $this->userInforErr['phoneErr'] = "Only numbers allowed";
            }
        }
        // check avatar
        if(empty($infor->avatar)){
            $this->userInfor['avatar'] = "";
            // $this->userInfor['avatar'] = "abc";            
        }else{
            $file = $infor->file('avatar');
            $img = '.' . $file->extension();
            $public = Storage::disk('public_folder');
            $public->putFileAs('images/user', $file, $infor->username . $img);            
            $avatar = UserController::test_input($img);
            $this->userInfor['avatar'] = $avatar;
            // $this->userInfor['file'] = $infor->avatar;
        }  
        if(empty($infor->group_id)){
            $this->userInfor['group_id'] = 0;
        }else{
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
        if(count($this->userInforErr) == 0){
            $this->response['status'] = "Success";
            // $this->userInfor = $request;
            $user->set($this->userInfor);
            // $user->save();
        }else{
            $this->response['status'] = "Error";
        }

        // var_dump($this->userInforErr); exit;
        $this->response['userInfor'] = $this->userInfor;
        $this->response['userInforErr'] = $this->userInforErr;
        // var_dump($this->userInforErr); exit;
        // return redirect()->route('users')->with(['user_id' => $user->id]);
        return json_encode($this->response);
     }

    /**
     * Handle edit user request submit
     */
    public function editUserHandler(Request $request)
    {
        $old = "";
        // $response['status'] = "Success";
        // $user = new User();
        if(!empty($request->user_id)){
            // var_dump("1");
            $user = User::where('id', $request->user_id)->first();
            $this->check_request($request);
            // var_dump($request->ava); exit;
            // check status
            if($this->userInforErr['emailErr'] == "Existed"){
                unset($this->userInforErr['emailErr']);
            }
            if($this->userInforErr['usernameErr'] == "Existed"){
                unset($this->userInforErr['usernameErr']);
            }
            // var_dump(json_encode($this->userInforErr)); exit;
            if(count($this->userInforErr) == 0){
                $this->response['status'] = "Success";
                // $this->userInfor = $request;
                // var_dump($this->userInfor); exit;
                $user->set($this->userInfor);
                $user->save();
                return redirect()->route('users')->with(['user_id' => $request->user_id, 'old' => '', 'uv' => '']);                
            }else{
                $this->userInfor['id'] = $user->id;
                $this->userInfor['avatar'] = $user->img;
                $this->response['status'] = "Error";
                // var_dump($this->userInforErr); exit;
                return redirect()->route('users')->with(['user_id' => $request->user_id,
                                                        'old' => json_encode($this->userInfor),
                                                        'uv' => $this->userInforErr]);


            }                       
        }

        $this->response['userInfor'] = $this->userInfor;
        $this->response['userInforErr'] = $this->userInforErr;

        // $abc = "abc";
        // var_dump($this->userInfor); exit;
        // return json_encode($this->response);
        // var_dump($request->user_id); exit;
        // return back()->with(['user_id' => $request->user_id, 'userInforErr' => $this->userInforErr]);
        return redirect()->route('users')->with(['user_id' => $request->user_id]);

        
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

    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}

