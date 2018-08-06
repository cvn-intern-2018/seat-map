<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\User;
use \Config;

class UserGroup extends Model
{

    /**
     * Disable timestamps
     */
    public $timestamps = false;

    /**
     * Check if a group name is available in the database
     * 
     * @param string $name String that need to check
     * @param bool  $lock Using table locking on update
     * @return int 
     */
    public static function isValidName(string $name, bool $lock )
    {
        $query = self::where('name', $name);
        if ($lock) {
            $query->lockForUpdate();
        }
        $result = $query->get();
        $count = $result->count();
        if ($count == 0) {
            return 0;
        }
        return $result->first()->id;
    }

    /**
     * Update new name for group
     * 
     * @param string $group_name;
     * @return bool 
     */
    public function updateGroupName(string $group_name)
    {
        // DB::beginTransaction();
        try {
            $check_result = self::isValidName($group_name, true);
            if ($check_result == 0) {
                $this->name = $group_name;
                $this->save();
                DB::commit();
                return true;
            } else {
                DB::rollback();
                if ($check_result == $this->id) {
                    return true;
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
        return false;
    }

    /**
     * Add new group to database
     * 
     * @param string $group_name
     * @return int 
     */
    public static function addNewGroup(string $group_name)
    {
        return self::insertGetId (['name' => $group_name]);        
    }

    /**
     * Delete a group
     * 
     * @param int $group_id
     */
    public function deleteGroup()
    {
        User::where('user_group_id', $this->id)->update([
            'user_group_id' => Config::get('constants.UNASSIGNED_GROUP_ID'),
        ]);
        $this->delete();
    }
    
}
