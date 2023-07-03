<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('recipe.index');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// userルーティング
Route::get('user/index', [UserController::class, 'index'])
            ->name('user.index');

Route::get('user/edit/{user}', [UserController::class, 'edit'])
            ->name('user.edit');

Route::patch('user/{user}', [UserController::class, 'update'])
            ->name('user.update');

Route::delete('user/{user}', [UserController::class, 'destroy'])
            ->name('user.destroy');

// recipeルーティング
Route::get('/', [RecipeController::class, 'index'])
            ->name('recipe.index');

Route::get('recipe/index', [RecipeController::class, 'index'])
            ->name('recipe.index');

Route::get('recipe/create', [RecipeController::class, 'create'])
            ->name('recipe.create');

Route::post('recipe/store', [RecipeController::class, 'store'])
            ->name('recipe.store');

Route::get('recipe/edit/{recipe}', [RecipeController::class, 'edit'])
            ->name('recipe.edit');

Route::patch('recipe/{recipe}', [RecipeController::class, 'update'])
            ->name('recipe.update');

Route::delete('recipe/{recipe}', [RecipeController::class, 'destroy'])
            ->name('recipe.destroy');




require __DIR__.'/auth.php';
