<?php

namespace AzizSama\LaPermission;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class LaPermission
{
    /**
     * Assign role permission
     * 
     * @param int $role_id
     * @param int $permission_id
     */
    public static function assignRolePermission(int $role_id, int $permission_id)
    {
        DB::table('lapermission_role_permission')->insert([
            'role_id' => $role_id,
            'permission_id' => $permission_id
        ]);
    }

    /**
     * Remove role permission
     * 
     * @param int $role_id
     * @param int $permission_id
     */
    public static function removeRolePermission(int $role_id, int $permission_id)
    {
        DB::table('lapermission_role_permission')->where([
            'role_id' => $role_id,
            'permission_id' => $permission_id
        ])->delete();
    }

    /**
     * Attach Role to user
     * 
     * @param int $user_id
     * @param int $role_id
     */
    public static function assignRoleToUser(int $user_id, int $role_id)
    {
        DB::table('lapermission_role_user')->insert([
            'roleable_type' => Config::get('lapermission.user.model'),
            'role_id' => $role_id,
            'roleable_id' => $user_id
        ]);
    }

    /**
     * Detach Role from user
     * 
     * @param int $user_id
     * @param int $role_id
     */
    public static function removeRoleFromUser(int $user_id, int $role_id)
    {
        DB::table('lapermission_role_user')->where([
            'role_id' => $role_id,
            'roleable_id' => $user_id
        ])->delete();
    }
}