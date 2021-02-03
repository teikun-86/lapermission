<?php

namespace AzizSama\LaPermission\Traits;

use AzizSama\LaPermission\LaPermission;
use AzizSama\LaPermission\Models\Permission;

trait HasPermission
{
    /**
     * retrieve the permission that role have
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
     * check if the role has the required permission
     */
    public function hasPermission($permission)
    {
        $count = $this->permissions()->where('name', $permission)->count();
        if($count > 0)
        {
            return true;
        }
        return false;
    }

    /**
     * Attach permission
     * 
     * @param string|array $permission
     */
    public function attachPermission($permissions)
    {
        if(is_array($permissions))
        {
            foreach($permissions as $permission)
            {
                if(!Permission::where('name', $permission)->first())
                {
                    throw new \Exception("Permission '$permission' not found. Please check the permission name carefully.");
                }
            }
        }
        else
        {
            if(!Permission::where('name', $permissions)->first())
            {
                throw new \Exception("Permission '$permissions' not found. Please check the permission name carefully.");
            }
        }
        if(!$this->hasPermission($permissions))
        {
            if(is_array($permissions))
            {
                foreach($permissions as $permission)
                {
                    $permission_id = Permission::where('name', $permission)->first()->id;
                    LaPermission::assignRolePermission($this->id, $permission_id);
                }
            }
            else
            {
                $permission_id = Permission::where('name', $permissions)->first()->id;
                LaPermission::assignRolePermission($this->id, $permission_id);
            }
        }
        else
        {
            if(is_array($permissions))
            {
                throw new \Exception("The $this->name role already has $permissions[0] permission.");
            }
            else
            {
                throw new \Exception("The $this->name role already has '$permissions' permission");
            }
        }
    }

    /**
     * Detach Permission
     * 
     * @param string|array $permissions
     */
    public function detachPermission($permissions)
    {
        if($this->hasPermission($permissions))
        {
            if(is_array($permissions))
            {
                foreach($permissions as $permission)
                {
                    $permission_id = Permission::where('name', $permission)->first()->id;
                    LaPermission::removeRolePermission($this->id, $permission_id);
                }
            }
            else
            {
                $permission_id = Permission::where('name', $permissions)->first()->id;
                LaPermission::removeRolePermission($this->id, $permission_id);
            }
        }
    }

}