<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use Tests\TestCase;
use App\Services\Recipe\RecipeService;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\User;
use App\Models\Cuisine;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeServiceTest extends TestCase
{
    use RefreshDatabase;

    private RecipeService $recipeService;
    private User $user;
    private Recipe $recipe;

    protected function setUp(): void
    {
        parent::setUp();

        $this->recipeService = new RecipeService();
        $this->user = User::factory()->create();
        $this->recipe = $this->createRecipe();
        $this->createIngredients($this->recipe->id);


        $this->actingAs($this->user);
    }


    /**
     * @return Recipe
     */
    private function createRecipe(): Recipe
    {
        $cuisine = Cuisine::create([
            'code' => Str::uuid(),
            'label' => 'Test',
        ]);

        return Recipe::create([
            'user_id' => $this->user->id,
            'cuisine_id' => $cuisine->id,
            'name' => 'Name',
            'description' => 'description',
        ]);
    }


    /**
     * @param $recipeId
     */
    private function createIngredients($recipeId): void
    {
        Ingredient::updateFromRecipe(
            [
                [
                    'name' => 'Ingredient name',
                    'count' => '40',
                    'unit' => 'g',
                ],
            ],
            $recipeId
        );
    }


    /** @test */
    public function getRecipe()
    {
        $recipe = $this->recipe;
        $result = $this->recipeService->get($recipe->id);

        $this->assertInstanceOf(\App\Http\Resources\RecipeResource::class, $result);
        $this->assertEquals($recipe->id, $result->id);
    }


    /** @test */
    public function accessDenied()
    {
        $recipe = $this->recipe;
        $otherUser = User::factory()->create();
        $this->actingAs($otherUser);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Access denied.');

        $this->recipeService->get($recipe->id);
    }


    /** @test */
    public function it_can_get_paginated_list_of_recipes_for_authenticated_user()
    {
        for ($i = 0; $i < 15; $i++) {
            $recipe = $this->createRecipe();
            $this->createIngredients($recipe->id);
        }

        $result = $this->recipeService->getList(5, 'updated_at', 'desc');

        $this->assertInstanceOf(\Illuminate\Http\Resources\Json\AnonymousResourceCollection::class, $result);
        $this->assertCount(5, $result->collection);
    }


    /** @test */
    public function filterList()
    {
        $newUser = User::factory()->create();
        $this->actingAs($newUser);

        Recipe::create([
            'user_id' => $newUser->id,
            'cuisine_id' => Cuisine::first()->id,
            'name' => 'Pasta Carbonara',
            'description' => 'description',
        ]);

        Recipe::create([
            'user_id' => $newUser->id,
            'cuisine_id' => Cuisine::first()->id,
            'name' => 'Chicken Curry',
            'description' => 'description',
        ]);

        $result = $this->recipeService->getList(5, 'updated_at', 'desc', 'Pasta');


        $this->assertCount(1, $result->collection);
        $this->assertEquals('Pasta Carbonara', $result->collection->first()->name);
    }


    /** @test */
    public function saveRecipe()
    {
        $cuisine = Cuisine::first();
        $recipe = new Recipe([
            'user_id' => null,
            'cuisine_id' => $cuisine->id,
            'name' => 'Save Test',
        ]);

        $ingredients = [
            ['name' => 'Flour', 'count' => 200, 'unit' => 'g'],
            ['name' => 'Sugar', 'count' => 100, 'unit' => 'g'],
        ];

        $recipeId = $this->recipeService->save($recipe, $ingredients);

        $this->assertDatabaseHas('recipes', [
            'id' => $recipeId,
            'user_id' => $this->user->id,
            'cuisine_id' => $cuisine->id,
        ]);

        $this->assertDatabaseHas('ingredients', [
            'recipe_id' => $recipeId,
            'name' => 'Flour',
        ]);
        $this->assertDatabaseHas('ingredients', [
            'recipe_id' => $recipeId,
            'name' => 'Sugar',
        ]);
    }


    /** @test */
    public function deleteTest()
    {
        $recipe = Recipe::create([
            'user_id' => $this->user->id,
            'cuisine_id' => Cuisine::first()->id,
            'name' => 'Delete Test',
        ]);

        $ingredient = Ingredient::create([
            'recipe_id' => $recipe->id,
            'name' => 'Test',
            'count' => 200,
            'unit' => 'g',
        ]);

        $result = $this->recipeService->delete($recipe->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('recipes', ['id' => $recipe->id]);
        $this->assertDatabaseMissing('ingredients', ['id' => $ingredient->id]);
    }
}
