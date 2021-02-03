<?php

namespace AzizSama\LaPermission\Console\Commands;

use AzizSama\LaPermission\Models\Permission;
use Illuminate\Console\Command;

class CreatePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:permission
                                    {name : Permission Name eg. write, delete, read update}
                                    {--description= : Permission description, eg. Permission to update/edit post} 
                                    {--no-description : Set description to null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Permission';

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
            $description = $this->ask('Create permission description (you can leave it blank)');
        }
        if($this->option('no-description'))
        {
            $description = null;
        }
        $this->table(['Name','Description'], [
            [
                'name' => $name,
                'description' => $description,
            ]
        ]);
        if($this->confirm("Do you wan't to confirm the creation of the new permission?", true))
        {
            Permission::create([
                'name' => $name,
                'description' => $description
            ]);

            $this->info('Successfully create new permission.');
        }
        else
        {
            $this->info('You cancelled new permission creation.');
        }
    }
}
