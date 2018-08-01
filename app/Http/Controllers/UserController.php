<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserGroup;
class UserController extends Controller
{
    /**
     * Load login form
     */
    public function getUsers()
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
                $userInfor['email'] = $user->email;
                $userInfor['phone'] = $user->phone;
                $userInfor['group'] = UserGroup::where('id', $user->user_group_id)->first()->name;
                $userInfor['password'] = $user->password;
                $userInfor['username'] = $user->username;
                $arr_users[$user->id] = json_encode($userInfor);
            }else{
                $admin['id'] = $user->id;
                $admin['fullname'] = $user->name;
                $admin['email'] = $user->email;
                $admin['phone'] = $user->phone;
                $admin['group'] = UserGroup::where('id', $user->user_group_id)->first()->name;
                $admin['password'] = $user->password;
                $admin['username'] = $user->username;
            }
        }

        // var_dump($arr_users);exit;
        // $param = [
        //     'users' => $users,
        //     'userj' => $arr_users,
        //     'admin' => json_encode($admin),
        // ];
        // var_dump($param);
        // exit;
        return view('user-setting', [  'users' => $users,
            'userj' => $arr_users,
            'admin' => json_encode($admin),
            'groups' => $groups]
            );
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
        
        $response = [];
        $userInforErr = [];
        $userInfor = [];
        $response['status'] = "Success";
        $user = new User();

        // check fullname
        if(empty($request->fullname)){
            $userInforErr['fullnameErr'] = "Full name is required";
            $response['status'] = "Error";
        } else {
            $fullname = UserController::test_input($request->fullname);
            if (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
                $userInforErr['fullnameErr'] = "Only letters and white space allowed";
                $response['status'] = "Error";
            } else {
                $userInfor['fullname'] = $fullname;
                $user->name = $fullname;
            }
        }

        // check username
        if (empty($request->username)) {
            $userInforErr['usernameErr'] = "Username is required";
            $response['status'] = "Error";
        } else {
            $username = UserController::test_input($request->username);
            if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                $userInforErr['nameErr'] = "Only letters and numbers allowed";
                $response['status'] = "Error";
            } else if (User::where('username', '=', $username)->count() > 0) {
                $userInforErr['usernameErr'] = "Existed";
                $response['status'] = "Error";
            } else {
                $userInfor['username'] = $username;
                $user->username = $username;
            }
        }


        // check email format
        if(!empty($request->email)){
            $email = UserController::test_input($request->email);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $userInforErr['emailErr'] = "Invalid email format";
                $response['status'] = "Error";
            }else{
                $userInfor['email'] = $email;
                $user->email = $email;
            }
        }

        // check phonenumber
        if (empty($request->phone)) {
            $userInforErr['phoneErr'] = "Phone number is required";
            $response['status'] = "Error";
        } else {
            $phone = UserController::test_input($request->phone);
            if (!preg_match("/^[0-9]*$/", $phone)) {
                $userInforErr['phoneErr'] = "Only numbers allowed";
            } else {
                $userInfor['phone'] = $phone;
                $user->phone = $phone;
            }
        }

        // check password
        if (empty($request->password)) {
            $userInforErr['passwordErr'] = "Password is required";
            $response['status'] = "Error";

        } else {
            $password = UserController::test_input($request->password);
            if (!preg_match("/^[a-zA-Z0-9]*$/", $password)) {
                $userInforErr['passwordErr'] = "Only letters and numbers allowed";
                $response['status'] = "Error";
            } else {
                $userInfor['password'] = $password;
                $user->password = $password;
            }
        }

        // check groupid
        if (empty($request->group_id)) {
            $userInforErr['group_idErr'] = "Group is required";
            $response['status'] = "Error";
        } else {
            $group_id = UserController::test_input($request->group_id);
            $userInfor['group_id'] = $group_id;
            $user->user_group_id = $group_id;
        }

        // check status
        if ($response['status'] == "Success") {
            $user->short_name = "";
            // delete
            // User::where('username', '=', $username)->delete();
            // save
            $user->save();
        }

        $response['userInfor'] = $userInfor;
        $response['userInforErr'] = $userInforErr;

        return json_encode($response);
        
        

       

        // return "status";
     }

    /**
     * Handle edit user request submit
     */
    public function editUserHandler(Request $request)
    {
        $response = [];
        $userInforErr = [];
        $userInfor = [];
        $response['status'] = "Success";
        // $user = new User();

                    // var_dump(JSON.parse($user));
                    // exit;
        if(!empty($request->user_id)){
            // $user = User::where('id', '=', $request->user_id);
            $user = User::where('id', $request->user_id)->first();
            // check username
            if (empty($request->username)) {
                $userInforErr['usernameErr'] = "Username is required";
                $response['status'] = "Error";
            } else {
                if($user->username != $request->username){
                    $username = UserController::test_input($request->username);

                    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                        $userInforErr['nameErr'] = "Only letters and numbers allowed";
                        $response['status'] = "Error";
                    } else if (User::where('username', '=', $username)->count() > 0) {
                        $userInforErr['usernameErr'] = "Existed";
                        $response['status'] = "Error";
                    } else {
                        $userInfor['username'] = $username;
                        $user->username = $username;
                    }

                }
                
            }

            // check fullname
            if(empty($request->fullname)){
                $userInforErr['fullnameErr'] = "Full name is required";
                $response['status'] = "Error";
            } else {
                if($user->name != $request->fullname){
                    $fullname = UserController::test_input($request->fullname);
                    if (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
                        $userInforErr['fullnameErr'] = "Only letters and white space allowed";
                        $response['status'] = "Error";
                    } else {
                        $userInfor['fullname'] = $fullname;
                        $user->name = $fullname;
                    }
                }
                
            }

            // check email format
            if(!empty($request->email)){
                if($user->email != $request->email){
                    $email = UserController::test_input($request->email);
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $userInforErr['emailErr'] = "Invalid email format";
                        $response['status'] = "Error";
                    }else{
                        $userInfor['email'] = $email;
                        $user->email = $email;
                    }
                }

            }

            // check phonenumber
            if (empty($request->phone)) {
                $userInforErr['phoneErr'] = "Phone number is required";
                $response['status'] = "Error";
            } else {
                if($user->phone != $request->phone){
                    $phone = UserController::test_input($request->phone);
                    if (!preg_match("/^[0-9]*$/", $phone)) {
                        $userInforErr['phoneErr'] = "Only numbers allowed";
                    } else {
                        $userInfor['phone'] = $phone;
                        $user->phone = $phone;
                    }                    
                }

            }

            // check password
            if (empty($request->password)) {
                $userInforErr['passwordErr'] = "Password is required";
                $response['status'] = "Error";

            } else {
                if($user->password != $request->password){
                    $password = UserController::test_input($request->password);
                    if (!preg_match("/^[a-zA-Z0-9]*$/", $password)) {
                        $userInforErr['passwordErr'] = "Only letters and numbers allowed";
                        $response['status'] = "Error";
                    } else {
                        $userInfor['password'] = $password;
                        $user->password = $password;
                    }
                }
            }

            // check status
            if ($response['status'] == "Success") {
                $user->short_name = "";
                // delete
                // User::where('username', '=', $username)->delete();
                // save
                $user->save();
            }



        }





        $response['userInfor'] = $userInfor;
        $response['userInforErr'] = $userInforErr;

        return json_encode($response);
        
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