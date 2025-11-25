<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CuisineResource;
use App\Models\Cuisine;
use Illuminate\Support\Facades\Cache;

class DimensionController extends Controller
{
    private const CACHE_KEY_CUISINE = 'cuisine';


    /**
     * @return mixed
     */
    public function getCuisine(): mixed
    {
        if (Cache::has(static::CACHE_KEY_CUISINE)) {
            return Cache::get(static::CACHE_KEY_CUISINE);
        }

        $dimension = CuisineResource::collection(Cuisine::all());

        Cache::add(static::CACHE_KEY_CUISINE, $dimension);
        return $dimension;
    }
}
