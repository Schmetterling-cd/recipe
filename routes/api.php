<?php

use App\Http\Controllers\Api\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__.'/dimension.php';

Route::get('/recipe/getList', [RecipeController::class, 'index']);
Route::get('/recipe/getCard/{id}', [RecipeController::class, 'rec']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/recipe/save', [RecipeController::class, 'save']);
    Route::delete('/recipe/delete', [RecipeController::class, 'delete']);
});
