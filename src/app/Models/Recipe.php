<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function ingredients(): belongsToMany
    {
        // laravelの中間テーブル名は複数形にしないルールが有る
        // 今回は複数形のテーブルを作成済みの為、belongsToManyの第二引数にテーブル名を指定
        return $this->belongsToMany(Ingredient::class, 'ingredients_recipes');
    }
}
