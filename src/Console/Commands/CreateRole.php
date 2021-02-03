<?php

namespace AzizSama\LaPermission\Console\Commands;

use AzizSama\LaPermission\Models\Role;
use Illuminate\Console\Command;

class CreateRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:role
                                    {name : Role Name eg. admin, writer, Super Admin}
                                    {--description= : Role description, eg. Owner of the project} 
                                    {--no-description : Set the description to null.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new role';

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
        $name = $this->argument('name');
        $description = $this->option('description');
        if(!$description && !$this->option('no-description'))
        {
            $description = $this->ask('Create role description (you can leave it blank)', null);
        }
        if($this->option('no-description'))
        {
            $description = null;
        }
        $this->table(
            [
                'Role Name',
                'Description'
            ],
            [
                [
                    'name' => $name,
                    'description' => $description
                ]
            ]
        );
        if($this->confirm("Do you wan't to confirm the role creation?", true))
        {
            Role::create([
                'name' => $name,
                'description' => $description ?? null,
            ]);
            $this->info("Successfully created new role $name.");
        }
        else
        {
            $this->info("You cancelled new role creation.");
        }
    }
}
