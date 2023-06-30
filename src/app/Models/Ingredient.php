<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// BelongsToManyのリレーションを使用する為に必要
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];

    // Recipeモデルとのリレーション
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'ingredients_recipes', 'ingredient_id', 'recipe_id');
    }
}
