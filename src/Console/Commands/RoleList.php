<?php

namespace AzizSama\LaPermission\Console\Commands;

use AzizSama\LaPermission\Models\Role;
use Illuminate\Console\Command;

class RoleList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lapermission:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show available roles';

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
        $roles = Role::select([
            'id', 'name', 'description'
        ])->get();

        $count = $roles->count();

        $this->table(
            [
                'ID', 'Role Name', 'description'
            ],
            $roles
        );

        $this->info("Showing $count rows.");
    }
}
