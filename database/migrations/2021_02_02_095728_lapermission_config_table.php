<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaPermissionConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lapermission_roles', function($table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
        });

        Schema::create('lapermission_permissions', function($table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
        });

        Schema::create('lapermission_role_user', function($table) {
            $table->id();
            $table->morphs('roleable');
            $table->foreignId('role_id')->constrained('lapermission_roles')->onDelete('cascade');
        });

        Schema::create('lapermission_role_permission', function($table) {
            $table->foreignId('permission_id')->constrained('lapermission_permissions')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('lapermission_roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lapermission_roles');
        Schema::dropIfExists('lapermission_permissions');
        Schema::dropIfExists('lapermission_role_user');
        Schema::dropIfExists('lapermission_role_permission');
    }
}
