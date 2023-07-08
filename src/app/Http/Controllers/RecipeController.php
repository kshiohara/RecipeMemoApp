<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Ingredient;
use App\Http\Requests\RecipeCreateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Handler;


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

        // レシピテーブルの情報を新しい順で取得
        $recipe_data = $recipe_query->orderBy('created_at', 'desc')->paginate(9);

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
                'user_id' => $recipe->user_id,
            ];
        };

        return view('recipe/index', compact('user', 'recipes', 'recipe_data'));
    }


    public function create()
    {
        return view('recipe/create');
    }

    public function store(RecipeCreateRequest $request)
    {
        $user = Auth::user();
        // 例外処理
        try {
            // userが有料会員だった場合の処理
            if ($user->payment == 1) {
                // トランザクション
                DB::transaction(function()use($request) {
                    // レシピデータの保存
                    $recipe = Recipe::create([
                        "name" => $request->name,
                        "link" => $request->link,
                        "rating" => $request->rating,
                        "status" => $request->status,
                        "comment" => $request->comment,
                        "user_id" => auth()->id(),
                    ]);

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
                                $ingredient = Ingredient::create([
                                    "name" => $ingredientData,
                                ]);
                                $recipe->ingredients()->attach($ingredient->id);
                            }
                        }
                    }
                });

                // 処理後にレシピ一覧ページに遷移
                return redirect()->route('recipe.index');


            } else { // userが無料会員だった場合の処理
                // ログインユーザーが登録したレシピ数をカウント
                $count = Recipe::where('user_id', auth()->id())->count();

                if ($count < 5) { // 5個までレシピを登録できる

                    // トランザクション
                    DB::transaction(function() use($request) {
                        // レシピデータの保存
                        $recipe = Recipe::create([
                            "name" => $request->name,
                            "link" => $request->link,
                            "rating" => $request->rating,
                            "status" => $request->status,
                            "comment" => $request->comment,
                            "user_id" => auth()->id(),
                        ]);

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
                                    $ingredient = Ingredient::create([
                                        "name" => $ingredientData,
                                    ]);
                                    $recipe->ingredients()->attach($ingredient->id);
                                }
                            }
                        }
                    });

                    // 処理後にレシピ一覧ページに遷移
                    return redirect()->route('recipe.index');

                } else {
                    // 5個以上登録しようとした場合
                    return redirect()->route('recipe.create')->with('message', '無料会員の登録個数は5個までになります。追加で登録したい場合は有料会員にアップグレードをお願いします。');
                }
            }
        } catch (\Exception $e) {
            // エラーメッセージをログに記録する
            info($e->getMessage());
        }
    }

    public function edit(Recipe $recipe)
    {
        return view('recipe/edit', compact('recipe'));
    }

    public function update(RecipeCreateRequest $request, Recipe $recipe)
    {
        // 例外処理
        try {
            DB::transaction(function()use($request, $recipe) {
                // レシピの更新
                $recipe->update([
                    'name' => $request->name,
                    'link' => $request->link,
                    'rating' => $request->rating,
                    'status' => $request->status,
                    'comment' => $request->comment,
                ]);

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
            });
            // レシピの更新が反映された状態でレシピ一覧ページにリダイレクト
            return redirect()->route('recipe.index');

        } catch (\Exception $e){
            info($e->getMessage());
        }
    }


    public function destroy(Request $request, Recipe $recipe)
    {
        // レシピと関連する材料を取得
        $ingredients = $recipe->ingredients;
        // 例外処理
        try {
            // トランザクション
            DB::transaction(function() use($request, $ingredients, $recipe){
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
            });
            // レシピ一覧に遷移
            return redirect()->route('recipe.index');

        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
}
