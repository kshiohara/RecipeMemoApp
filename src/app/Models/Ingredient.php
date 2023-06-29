<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];

    // Recipeモデルとのリレーション
    public function recipes(): belongsToMany
    {
        // laravelの中間テーブル名は複数形にしないルールが有る
        // 今回は複数形のテーブルを作成済みの為、belongsToManyの第二引数にテーブル名を指定
        return $this->belongsToMany(Recipe::class, 'ingredients_recipes');
    }
}
