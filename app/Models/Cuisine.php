<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cuisine extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'code',
        'label',
    ];


    public $timestamps = false;


    /**
     * Ingredients relation
     *
     * @return BelongsTo
     */
    public function recipes(): BelongsTo
    {
        return $this->belongsTo(Recipe::class, 'cuisine_id', 'id');
    }
}
