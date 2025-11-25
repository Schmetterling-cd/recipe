<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ingredient extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'recipe_id',
        'name',
        'count',
        'unit',
    ];


    /**
     * Recipe relation
     *
     * @return BelongsTo
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class, 'id', 'recipe_id');
    }


    public static function updateFromRecipe($ingredients, $recipeId)
    {
        foreach ($ingredients as &$ingredient) {
            $ingredientModel = !empty($ingredient['id'])
                ? Ingredient::find($ingredient['id'])
                : new Ingredient()
            ;

            $ingredientModel->fill($ingredient);
            $ingredientModel->recipe_id = $recipeId;

            if ($ingredientModel->isDirty()) {
                $ingredientModel->save();
            }

            $ingredient['id'] = $ingredientModel->id;
        }

        self::where('recipe_id', '=', $recipeId)
            ->whereNotIn('id', array_column($ingredients, 'id'))
            ->delete()
        ;
    }
}
