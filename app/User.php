<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use \Config;

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

    public static function updateUserGroup(int $group_id, array $assign, array $unassign)
    {
        self::whereIn('id', $assign)->update(['user_group_id' => $group_id]);
        self::whereIn('id', $unassign)->update(['user_group_id' => Config::get('constants.UNASSIGNED_GROUP_ID')]);
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
