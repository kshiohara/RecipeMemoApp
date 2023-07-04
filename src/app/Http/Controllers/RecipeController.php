<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Ingredient;

use Illuminate\Support\Facades\Auth;


class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 検索フォームに入力された値を取得
        $search = $request->input('search');
        // レシピテーブルから全ての情報を取得
        $recipe_query = Recipe::query();

        // 検索フォームが空でない場合、レシピ名/材料名と一致するデータを取得
        if (!empty($search)) {
            $recipe_query->where('name', 'LIKE', "%{$search}%")
            ->orwhereHas('ingredients', function ($ingredient_query) use ($search) {
                $ingredient_query->where('name', 'LIKE', "%{$search}%");
            });
        }

        // 検索キーワードと一致した情報を新しい順で取得
        $recipe_data = $recipe_query->orderBy('created_at', 'desc')->get();
        $recipes = [];

        foreach($recipe_data as $recipe){
            // recipeに関連するingredientsテーブルのnameカラムから情報を配列の形で取得
            $ingredients = $recipe->ingredients()->pluck('name')->toArray();

            $recipes[] = [
                'id' => $recipe->id,
                'name' => $recipe->name,
                'link' => $recipe->link,
                'rating' => $recipe->rating,
                'status' => $recipe->status,
                'comment' => $recipe->comment,
                'ingredients' => $ingredients,
            ];
        };

        return view('recipe/index', compact('user', 'recipes'));
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

        // 処理後にレシピ一覧ページに遷移
        return redirect()->route('recipe.index');
    }

        // $validated = $request->validate([
            // 'name' => ['required', 'string', 'max:100'],
            // 'link' => ['required', 'string', 'max:2084'],
            // 'rating' => ['nullable', 'integer'],
            // 'status' => ['required', 'in:1,2'],
            // 'comment' => ['nullable', 'string'],
            // 'user_id' => ['required'],
            // ]);

            // auth()->id() : ログインユーザのid情報

            // $recipe = Recipe::create($validated);


    public function edit(Recipe $recipe)
    {
        return view('recipe/edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'link' => ['required', 'string', 'max:2084'],
            'rating' => ['nullable', 'integer'],
            'status' => ['required', 'in:1,2'],
            'comment' => ['nullable', 'string'],
        ]);

        // レシピの更新
        $recipe->update($validated);

        // 材料の更新
        $ingredients = $request->ingredients;

        // レシピと関連のある材料を中間テーブルから解除
        $recipe->ingredients()->detach();

        foreach($ingredients as $ingredient){
            // 材料が空ではない場合のみ処理
            if (!empty($ingredient)) {
                // ingredientsテーブルのnameカラムの値が送信された材料名と一致するデータを取得
                $existingIngredient = Ingredient::where('name', $ingredient)->first();
                // 材料がDBに存在する場合
                if ($existingIngredient) {
                    // $existingIngredientを新しいレシピと関連付ける
                    $recipe->ingredients()->attach($existingIngredient->id);
                } else {
                    // 新しい材料を作成
                    $ingredient = Ingredient::create(['name' => $ingredient]);
                    // 新しい材料を新しいレシピと関連付ける
                    $recipe->ingredients()->attach($ingredient->id);
                }
            }
        }

        // recipesテーブルと関係のない材料を取得して、削除
        $unusedIngredients = Ingredient::doesntHave('recipes')->get();
        $unusedIngredients->each(function($ingredient){
            $ingredient->delete();
        });

        // レシピの更新が反映された状態でレシピ一覧ページにリダイレクト
        return redirect()->route('recipe.index');
    }


    public function destroy(Request $request, Recipe $recipe)
    {
        // レシピと関連する材料を取得
        $ingredients = $recipe->ingredients;

        // 各材料を削除
        foreach($ingredients as $ingredient) {
            // 削除予定の材料を使用している他のレシピが存在してない場合のみ処理
            if ($ingredient->recipes()->count() <= 1) {
                // レシピと関連する材料の関連を解除
                $recipe->ingredients()->detach($ingredient->id);
                // 材料を削除
                $ingredient->delete();
            }
        }

        // レシピを削除
        $recipe->delete();
        // レシピ一覧に遷移
        return redirect()->route('recipe.index');
    }



}
