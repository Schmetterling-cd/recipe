<?php

namespace App\Contracts\Recipe;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface RecipeInterface
{
    public function get(int $id): RecipeResource;
    public function getList(
        int $pageSize,
        string $sortBy,
        string $sortOrder,
        string $searchQuery
    ): AnonymousResourceCollection;
    public function save(Recipe $recipe, array $ingredients, ?string $image): int;
    public function delete(int $id): bool;
}
