<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Recipe\RecipeInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Rules\Base64Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class RecipeController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    private function validateRecipeData(Request $request): array
    {
        return $request->validate([
            'id' => 'integer|nullable',
            'cuisine_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'string',
            'image' => ['nullable', new Base64Image()],
        ]);
    }


    /**
     * @param Request $request
     * @return array
     */
    private function validateIngredients(Request $request): array
    {
        return $request->validate([
            'ingredients' => 'required|array|min:1',
            'ingredients.*.id' => 'integer|nullable',
            'ingredients.*.name' => 'required|string|max:255',
            'ingredients.*.count' => 'required|numeric|min:0',
            'ingredients.*.unit' => 'required|string|max:50',
        ])['ingredients'];
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, RecipeInterface $recipeService): AnonymousResourceCollection
    {
        return $recipeService->getList(
            $request->get('size') ?? 5,
            $request->get('sortBy') ?? 'updated_at',
            $request->get('sortOrder') ?? 'desc',
            $request->get('searchQuery'),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request, RecipeInterface $recipeService): JsonResponse
    {
        $recipe = $request->has('id') && empty($request->get('id')) === false
            ? Recipe::find($request->get('id'))
            : new Recipe()
        ;

        $recipeData = $this->validateRecipeData($request);
        $recipe->fill($recipeData);
        $recipeService->save($recipe, $this->validateIngredients($request), $recipeData['image'] ?? null);

        return ResponseHelper::create()
            ->withRedirect('/')
            ->send()
        ;
    }

    /**
     * Display the specified resource.
     */
    public function rec($id, RecipeInterface $recipeService)
    {
        return $recipeService->get($id)->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, RecipeInterface $recipeService): JsonResponse
    {
        $responseHelper = ResponseHelper::create();

        return $recipeService->delete($request->get('id'))
            ? $responseHelper
                ->withRedirect('/')
                ->withMessage('Deleted successfully!', self::STATUS_SUCCESS)
                ->send()
            : $responseHelper
                ->withMessage('Failed to delete record.', self::STATUS_ERROR)
                ->send()
        ;
    }
}
