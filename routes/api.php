<?php

use App\Http\Controllers\Api\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__.'/dimension.php';

Route::get('/user', function (Request $request) {
    return $request->user() ?? null;
});

Route::get('/recipe/getList', [RecipeController::class, 'index']);
Route::get('/recipe/getCard/{id}', [RecipeController::class, 'rec']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/recipe/save', [RecipeController::class, 'save']);
    Route::delete('/recipe/delete', [RecipeController::class, 'delete']);

});
