<?php

use App\Http\Controllers\Api\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__.'/dimension.php';

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/recipe/getCard/{id}', [RecipeController::class, 'rec']);
    Route::post('/recipe/save', [RecipeController::class, 'save']);
    Route::delete('/recipe/delete', [RecipeController::class, 'delete']);
    Route::get('/recipe/getList', [RecipeController::class, 'index']);

});
