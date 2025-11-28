<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        config(['database.connections.mysql.username' => 'root']);
        config(['database.connections.mysql.password' => env('DB_PASSWORD')]);

        DB::reconnect();

        $username = env('DB_USERNAME');

        DB::statement('CREATE DATABASE IF NOT EXISTS testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        DB::statement("GRANT ALL PRIVILEGES ON testing.* TO '{$username}'@'%'");
        DB::statement("FLUSH PRIVILEGES");

        config(['database.connections.mysql.username' => $username]);
        config(['database.connections.mysql.password' => env('DB_PASSWORD')]);
        DB::reconnect();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        config(['database.connections.mysql.username' => 'root']);
        config(['database.connections.mysql.password' => env('DB_PASSWORD')]);

        DB::reconnect();

        $username = env('DB_USERNAME');

        DB::statement("REVOKE ALL PRIVILEGES ON testing.* FROM '{$username}'@'%'");
        DB::statement("FLUSH PRIVILEGES");

        config(['database.connections.mysql.username' => $username]);
        config(['database.connections.mysql.password' => env('DB_PASSWORD')]);
        DB::reconnect();
    }
};
