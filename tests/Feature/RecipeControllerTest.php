<?php

namespace Tests\Feature;

use App\Models\Cuisine;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Recipe $recipe;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->recipe = $this->createRecipe();
        $this->createIngredients($this->recipe->id);

        Sanctum::actingAs($this->user);
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
    public function getRecipeList()
    {
        for ($i = 0; $i < 15; $i++) {
            $recipe = $this->createRecipe();
            $this->createIngredients($recipe->id);
        }

        $response = $this->getJson('/api/recipe/getList?size=5&sortBy=name&sortOrder=asc');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta'
            ])
            ->assertJsonCount(5, 'data')
        ;
    }


    /** @test */
    public function createNewRecipe()
    {
        $recipeData = [
            'cuisine_id' => 1,
            'name' => 'Test Recipe',
            'description' => 'Test Description',
            'ingredients' => [
                ['name' => 'Flour', 'count' => 200, 'unit' => 'g'],
                ['name' => 'Water', 'count' => 100, 'unit' => 'ml'],
            ]
        ];

        $response = $this->postJson('/api/recipe/save', $recipeData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('recipes', [
            'name' => 'Test Recipe',
            'user_id' => $this->user->id
        ]);

        $this->assertDatabaseHas('ingredients', [
            'name' => 'Flour',
            'count' => 200
        ]);
    }


    /** @test */
    public function updateRecipe()
    {
        $updateData = [
            'id' => $this->recipe->id,
            'cuisine_id' => Cuisine::first()->id,
            'name' => 'Updated Recipe Name',
            'description' => 'Updated Description',
            'ingredients' => [
                [
                    'id' => $this->recipe->ingredients->first()->id,
                    'name' => 'Updated Ingredient',
                    'count' => 300,
                    'unit' => 'g'
                ],
                ['name' => 'New Ingredient', 'count' => 150, 'unit' => 'ml'],
            ]
        ];

        // Act
        $response = $this->postJson('/api/recipe/save', $updateData);

        // Assert
        $response->assertStatus(200);

        $this->assertDatabaseHas('recipes', [
            'id' => $this->recipe->id,
            'name' => 'Updated Recipe Name'
        ]);

        $this->assertDatabaseHas('ingredients', [
            'name' => 'Updated Ingredient',
            'count' => 300
        ]);
    }
}
