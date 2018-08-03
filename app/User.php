<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Disable timestamps
     */
    public $timestamps = false;

    /**
     * Disable rememberToken
     */

    public function getRememberToken()
    {
        return null;
    }

    // public function getRememberToken(){}
    public function getRememberTokenName()
    {
        return null;
    }

    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute) {
            parent::setAttribute($key, $value);
        }
    }

    public function group()
    {
        return $this->belongsTo('App\UserGroup', 'user_group_id');
    }

    /**
     * Get array of user's avatar URL
     *
     * @param array|Illuminate\Support\Collection $user_list
     * @return array
     */
    public static function getUserAvatar($user_list)
    {
        $avatars = [];
        foreach ($user_list as $user) {
            if (Storage::disk('public_folder')->exists('images/user/' . $user->id . '.jpg')) {
                $avatars[$user->id] = asset('images/user/' . $user->id . '.jpg');
            } elseif (Storage::disk('public_folder')->exists('images/user/' . $user->id . '.png')) {
                $avatars[$user->id] = asset('images/user/' . $user->id . '.png');
            } elseif (Storage::disk('public_folder')->exists('images/user/' . $user->id . '.bmp')) {
                $avatars[$user->id] = asset('images/user/' . $user->id . '.bmp');
            } elseif (Storage::disk('public_folder')->exists('images/user/' . $user->id . '.gif')) {
                $avatars[$user->id] = asset('images/user/' . $user->id . '.gif');
            } else {
                $avatars[$user->id] = asset('images/user/mys-man.jpg');
            }
        }
        return $avatars;
    }

    function set($infor){
        if(!empty($infor->name)){
        $this->name = $infor->name;            
        }

        if(!empty($infor->email)){
        $this->email = $infor->email;            
        }

        if(!empty($infor->password)){
        $this->password = $infor->password;            
        }

        if(!empty($infor->short_name)){
        $this->short_name = $infor->name;            
        }

        if(!empty($infor->img)){
        $this->img = $infor->img;            
        }

        if(!empty($infor->phone)){
        $this->phone = $infor->phone;            
        }

        if(!empty($infor->user_group_id)){
        $this->phone = $user_group_id;            
        }        
    }
}
