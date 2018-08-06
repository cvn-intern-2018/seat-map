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

    public function getUserById()
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

    function set($infor)
    {
        if (!empty($infor['fullname'])) {
            $this->name = $infor['fullname'];
        } else {
            $this->name = "";
        }

        if (!empty($infor['email'])) {
            $this->email = $infor['email'];
        } else {
            $this->email = "";
        }

        if (!empty($infor['password'])) {
            $this->password = $infor['password'];
        } else {
            $this->password = "";
        }

        if (!empty($infor['shortname'])) {
            $this->short_name = $infor['shortname'];
        } else {
            $this->short_name = "";
        }

        if (!empty($infor['avatar'])) {
            $this->img = $infor['avatar'];
            // var_dump("abc"); exit;           
        } else {
            $this->img = "";
        }

        if (!empty($infor['phone'])) {
            $this->phone = $infor['phone'];
        } else {
            $this->phone = 0;
        }

        if (!empty($infor['group_id'])) {
            $this->user_group_id = $infor['group_id'];
        } else {
            $this->user_group_id = 1;
        }

        if (!empty($infor['username'])) {
            $this->username = $infor['username'];
        } else {
            $this->username = "";
        }
    }
}
