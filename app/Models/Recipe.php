<?php

namespace App\Models;

use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Recipe extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'cuisine_id',
        'name',
        'description',
        'image_path',
    ];


    /**
     * Ingredients relation
     *
     * @return HasMany
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class, 'recipe_id', 'id');
    }


    /**
     * Cuisine relation
     *
     * @return hasOne
     */
    public function cuisine(): HasOne
    {
        return $this->hasOne(Cuisine::class, 'id', 'cuisine_id');
    }


    /**
     * @param Request $request
     */
    public function saveImage($image): void
    {
        if ($this->image_path) {
            Storage::disk('public')->delete($this->image_path);
        }

        $this->image_path = FileHelper::saveBase64Image($image);
    }


    /**
     * SetUp hooks
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($recipe) {
            $recipe->ingredients()->delete();
        });
    }
}
