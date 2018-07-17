<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index()
    {
        $pass = [];
        $pass['variable'] = sprintf('%1$s has passed to view index this string.', get_class($this));
        $pass['menu'] = [];
        if (Auth::check()) {
            $menu_login = array ('text' => 'Dashboard', 'link' => route('dashboard'));
            $pass['add_menu'][] = $menu_login;
        }
        else {
            $menu_login = array ('text' => 'Login', 'link' => route('login'));
            $pass['add_menu'][] = $menu_login;
        }

        return view( 'index', $pass );
    }
    public function getLoginView(Type $var = null)
    {
        return view('login');
    }
    
}
