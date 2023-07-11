<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.index', compact('user'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'kana' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'payment' => ['required', 'integer', 'between:1,2'],
        ]);

        $user->update($validated);
        return view('user.index', compact('user'));
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();
        $request->session()->flash('message', '削除しました');
        return redirect()->route('recipe.index');
    }

}
