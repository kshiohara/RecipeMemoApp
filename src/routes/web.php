<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('recipe.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// userルーティング
// Route::resource('user', UserController::class);

Route::get('user/index', [UserController::class, 'index'])
            ->name('user.index');

Route::get('user/edit/{user}', [UserController::class, 'edit'])
            ->name('user.edit');

Route::patch('user/{user}', [UserController::class, 'update'])
            ->name('user.update');

// Route::post('user/{user}', [UserController::class, 'update'])
//             ->name('user.update');

Route::delete('user/{user}', [UserController::class, 'destroy'])
            ->name('user.destroy');


// recipeルーティング
Route::get('recipe/index', [RecipeController::class, 'index'])
            ->name('recipe.index');

Route::get('recipe/create', [RecipeController::class, 'create'])
            ->name('recipe.create');

Route::get('recipe/store', [RecipeController::class, 'store'])
            ->name('recipe.store');




require __DIR__.'/auth.php';
