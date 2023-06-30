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
        $ingredients = $request->input('ingredients');

        foreach($ingredients as $ingredientData) {
            $ingredient = new Ingredient();
            $ingredient->name = $ingredientData['name'];
            $ingredient->recipe_id = $recipe->id;
            $ingredient->save();
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
