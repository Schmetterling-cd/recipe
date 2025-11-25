<?php

use App\Http\Controllers\Api\DimensionController;
use Illuminate\Support\Facades\Route;

Route::get('/dimension/cuisine', [DimensionController::class, 'getCuisine']);
