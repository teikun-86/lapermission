<?php

namespace AzizSama\LaPermission\Console\Commands;

use App\Models\User;
use AzizSama\LaPermission\LaPermission;
use AzizSama\LaPermission\Models\Permission;
use AzizSama\LaPermission\Models\Role;
use Illuminate\Console\Command;

class AssignPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lapermission:assign-permission
                                    {permission_id? : Permission ID}
                                    {role_id? : Role ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign permission to role';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $role_id = $this->argument('role_id');
        $permission_id = $this->argument('permission_id');
        if(!$role_id)
        {
            $role_id = $this->ask("Role Id is required");
        }
        if(!$permission_id)
        {
            $permission_id = $this->ask("Permission Id is required");
        }
        $role = Role::where('id', $role_id)->first();
        $permission = Permission::where('id', $permission_id)->first();
        if(!$role) { $this->error("Can not find the role with id = $role_id"); die;}
        if(!$permission) { $this->error("Can not find the permission with id = $permission_id"); die;}

        if(!$role->hasPermission($permission->name))
        {
            LaPermission::assignRolePermission($role_id, $permission_id);
            $this->info("Successfully assign permission '$permission->name' to '$role->name' role.");
        }
        else
        {
            $this->error("The '$role->name' already has '$permission->name' permission.");
        }
    }
}
