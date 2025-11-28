<?php

namespace App\Http\Resources;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cuisine' => new CuisineResource($this->cuisine),
            'name' => $this->name,
            'description' => $this->description,
            'ingredients' => IngredientResource::collection($this->ingredients()->get()),
            'image' => $this->image_path ? Storage::url($this->image_path) : null,
            'isEditable' => Gate::inspect('update', Recipe::find($this->id))->allowed(),
            'isDeletable' => Gate::inspect('delete', Recipe::find($this->id))->allowed(),
            'updated_at' => date("d.m.Y H:i", strtotime($this->updated_at)),
        ];
    }
}
