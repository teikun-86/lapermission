<?php

namespace AzizSama\LaPermission\Console\Commands;

use App\Models\User;
use AzizSama\LaPermission\LaPermission;
use AzizSama\LaPermission\Models\Role;
use Illuminate\Console\Command;

class AssignRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lapermission:assign-role
                                    {user_id? : User ID}
                                    {role_id? : Role ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign role to user';

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
        $user_id = $this->argument('user_id');
        if(!$role_id)
        {
            $role_id = $this->ask("Role Id is required");
        }
        if(!$user_id)
        {
            $user_id = $this->ask("User Id is required");
        }
        $user = User::where('id', $user_id)->first();
        $role = Role::where('id', $role_id)->first();
        if($user) { $this->info("Found user '$user->name'."); }
        else { $this->error("Can not find user with id = $user_id."); die;}
        if($role) { $this->info("Found role '$role->name'."); }
        else { $this->error("Can not find role with id = $role_id."); die;}

        if($role && $user && !$user->hasRole($role->name))
        {
            LaPermission::assignRoleToUser($user->id, $role->id);
            $this->info("Successfully assigned role $role->name to $user->name");
        }
        else
        {
            $this->error("User already has '$role->name' role.");
        }
    }
}
