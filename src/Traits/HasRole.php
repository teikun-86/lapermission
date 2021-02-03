<?php

namespace AzizSama\LaPermission\Traits;

use AzizSama\LaPermission\LaPermission;
use AzizSama\LaPermission\Models\Permission;
use AzizSama\LaPermission\Models\Role;

trait HasRole
{
    /**
     * Check if the authenticated user has the required role
     */
    public function hasRole($role)
    {
        $count = $this->roles()->where('name', $role)->count();
        if($count > 0)
        {
            return true;
        }
        return false;
    }

    /**
     * retrieve the authenticated user roles
     */
    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'lapermission_role_user',
            'roleable_id',
            'role_id'
        );
    }

    /**
     * retrieve the permission that authenticated user have
     */
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'lapermission_role_permission',
            'role_id',
            'permission_id'
        );
    }

    /**
     * check if the authenticated user has the required permission
     */
    public function hasPermission($permission)
    {
        $count =  $this->permissions()->where('name', $permission)->count();
        if($count > 0)
        {
            return true;
        }
        return false;
    }

    /**
     * Attach role
     * 
     * @param string $role
     */
    public function attachRole($role)
    {
        $rl = Role::where('name', $role)->first();
        if($rl)
        {
            if($this->hasRole($role))
            {
                throw new \Exception("The user already has '$role' role.", 1);
            }
            LaPermission::assignRoleToUser($this->id, $rl->id);
        }
        else
        {
            throw new \Exception("Role not found '$role'. Please check the role name carefully.", 1);
        }
    }

}