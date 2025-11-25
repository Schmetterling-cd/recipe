<?php

namespace App\Services\Recipe;

use App\Contracts\Recipe\RecipeInterface;
use App\Http\Resources\RecipeResource;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class RecipeService implements RecipeInterface
{
    /**
     * @param int $id
     * @return RecipeResource
     */
    public function get(int $id): RecipeResource
    {
        return new RecipeResource(Recipe::with(['ingredients', 'cuisine'])->find($id));
    }


    /**
     * @param int $pageSize
     * @return AnonymousResourceCollection
     */
    public function getList(
        int $pageSize,
        string $sortBy,
        string $sortOrder,
        string $searchQuery = null
    ): AnonymousResourceCollection {
        $list = (new Recipe())->with(['ingredients'])
            ->orderBy($sortBy, $sortOrder)
        ;

        if ($searchQuery) {
            $list->whereLike('name', "%{$searchQuery}%");
        }

        if (Auth::check()) {
            $list->where('user_id', '=', Auth::user()->id);
        }

        return RecipeResource::collection($list->paginate($pageSize));
    }


    /**
     * @param Recipe $recipe
     * @param array $ingredients
     * @return int
     */
    public function save(Recipe $recipe, array $ingredients, ?string $image = null): int
    {
        if (Gate::inspect('update', $recipe)->denied()) {
            throw new \Exception('Access denied.');
        }

        return DB::transaction(function () use ($recipe, $ingredients, $image) {
            $recipe->user_id = Auth::user()->id;

            if (!empty($image)) {
                $recipe->saveImage($image);
            }

            if ($recipe->isDirty()) {
                $recipe->save();
            }

            Ingredient::updateFromRecipe($ingredients, $recipe->id);
            return $recipe->id;
        });
    }


    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        $recipe = Recipe::find($id);

        if (Gate::inspect('delete', $recipe)->denied()) {
            throw new \Exception('Access denied.');
        }

        return $recipe->delete();
    }
}
