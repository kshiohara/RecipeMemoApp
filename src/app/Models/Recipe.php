<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// BelongsToManyのリレーションを使用する為に必要
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'link',
        'rating',
        'status',
        'comment',
        'user_id',
    ];


    // Userモデルとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Ingredientモデルとのリレーション
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'ingredients_recipes', 'recipe_id', 'ingredient_id');
    }
}
