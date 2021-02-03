<?php

namespace AzizSama\LaPermission\Console\Commands;

use AzizSama\LaPermission\Models\Permission;
use Illuminate\Console\Command;

class PermissionList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lapermission:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show available permissions';

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
        $permissions = Permission::select([
            'id', 'name', 'description'
        ])->get();

        $count = $permissions->count();

        $this->table(
            [
                'ID', 'Permission Name', 'Description',
            ],
            $permissions
        );

        $this->info("Showing $count rows.");
    }
}
