<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    public function index()
    {
        return view('recipe/index');
    }

    public function create()
    {
        return view('recipe/create');
    }

    // (Request $request) : formで送信されたデータを受け取ることを意味する
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'link' => ['required', 'string', 'max:2084'],
            'rating' => ['nullable', 'integer'],
            'status' => ['required', 'in:1,2'],
            'comment' => ['nullable', 'string'],
        ]);

        // auth()->id() : ログインユーザのid情報
        $validated['user_id'] = auth()->id();

        $recipe = Recipe::create($validated);

        $request->session()->flash('message', '保存しました');
        // 処理後に元のページに戻る
        return back();
    }
}
