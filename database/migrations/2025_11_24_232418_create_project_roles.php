<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('code')->unique();
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('object');
            $table->string('action');
            $table->string('label');
            $table->unique(['object', 'action']);
            $table->timestamps();
        });


        Schema::create('users_to_roles', function (Blueprint $table) {
            $table->id()->primary();
            $table->bigInteger('user_id');
            $table->bigInteger('role_id');
            $table->unique(['user_id', 'role_id']);
            $table->timestamps();
        });

        Schema::create('roles_to_permissions', function (Blueprint $table) {
            $table->id()->primary();
            $table->bigInteger('role_id');
            $table->bigInteger('permission_id');
            $table->unique(['role_id', 'permission_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('users_to_roles');
        Schema::dropIfExists('roles_to_permissions');
    }
};
