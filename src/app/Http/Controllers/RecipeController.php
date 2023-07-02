<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Ingredient;

use Illuminate\Support\Facades\Auth;


class RecipeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('recipe/index', compact('user'));
    }

    public function create()
    {
        return view('recipe/create');
    }

    // (Request $request) : formで送信されたデータを受け取ることを意味する
    public function store(Request $request)
    {
        // validation必要
        // レシピデータの保存
        $recipe = new Recipe();
        $recipe->name = $request->name;
        $recipe->link = $request->link;
        $recipe->rating = $request->rating;
        $recipe->status = $request->status;
        $recipe->comment = $request->comment;
        $recipe->user_id = auth()->id();
        $recipe->save();

        // 材料データの保存
        $ingredients = $request->ingredients;

        foreach($ingredients as $ingredientData) {
            // 材料が空ではない場合のみ処理
            if (!empty($ingredientData)) {
                // ingredientsテーブルのnameカラムの値が送信された材料名と一致するデータを取得
                $existingIngredient = Ingredient::where('name', $ingredientData)->first();

                // 材料がDBに存在する場合
                if ($existingIngredient) {
                    // $existingIngredientを新しいレシピと関連付ける
                    $recipe->ingredients()->attach($existingIngredient->id);
                } else {
                    // 材料を新規登録する場合
                    $ingredient = new Ingredient();
                    $ingredient->name = $ingredientData;
                    $ingredient->save();

                    $recipe->ingredients()->attach($ingredient->id);
                }
            }
        }


        // $validated = $request->validate([
        //     'name' => ['required', 'string', 'max:100'],
        //     'link' => ['required', 'string', 'max:2084'],
        //     'rating' => ['nullable', 'integer'],
        //     'status' => ['required', 'in:1,2'],
        //     'comment' => ['nullable', 'string'],
        //     'user_id' => ['required'],
        // ]);

        // auth()->id() : ログインユーザのid情報

        // $recipe = Recipe::create($validated);

        // 処理後にレシピ一覧ページに遷移
        return redirect('/');
    }
}
