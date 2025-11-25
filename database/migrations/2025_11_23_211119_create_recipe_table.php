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
        if (!Schema::hasTable('cuisines')) {
            Schema::create('cuisine', function (Blueprint $table) {
                $table->id()->primary();
                $table->string('code');
                $table->string('label');
            });
        }

        if (!Schema::hasTable('recipes')) {
            Schema::create('recipe', function (Blueprint $table) {
                $table->id()->primary();
                $table->integer('user_id')->constrained();
                $table->integer('cuisine_id')->constrained();
                $table->string('name');
                $table->text('description');
                $table->string('image_path');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('ingredients')) {
            Schema::create('ingredients', function (Blueprint $table) {
                $table->id()->primary();
                $table->integer('recipe_id')->constrained();
                $table->string('name');
                $table->integer('count');
                $table->string('unit');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe');
        Schema::dropIfExists('cuisine');
        Schema::dropIfExists('ingredients');
    }
};
