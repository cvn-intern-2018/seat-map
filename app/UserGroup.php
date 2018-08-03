<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserGroup extends Model
{

    /**
     * Disable timestamps
     */
    public $timestamps = false;

    public static function isValidName($name, $lock = false)
    {
        $query = self::where('name', $name);
        if ($lock) {
            $query->lockForUpdate();
        }
        if ($query->count() == 0) {
            return true;
        }
        return false;
    }

    public function updateGroupName($group_name)
    {
        DB::beginTransaction();
        try {
            if (self::isValidName($group_name, true)) {
                $this->name = $group_name;
                $this->save();
                DB::commit();
                return true;
            } else {
                DB::rollback();
            }
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
        return false;
    }
    
}
