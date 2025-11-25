<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RecipePolicy extends CommonPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Recipe $recipe): bool
    {
        return Auth::check() && ($user->id === $recipe->user_id || empty($recipe->id));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id;
    }
}
