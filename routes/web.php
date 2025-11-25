<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('storage/uploads/{path}', function ($path) {
    $fullPath = storage_path('app/public/uploads/' . $path);

    if (!file_exists($fullPath)) {
        abort(404);
    }

    return response()->file($fullPath);
})->where('path', '.*');

Route::get('{all}', function () {
    return view('app');
})->where('all', '.*');
