<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/our_targets', [App\Http\Controllers\OurTargetController::class, 'index'])->middleware('throttle:10, 1');

Route::resource('targets', 'App\Http\Controllers\TargetController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1');
Route::resource('ideas', 'App\Http\Controllers\IdeaController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']]);
Route::resource('private_categories', 'App\Http\Controllers\PrivateCategoryController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1');
Route::resource('books', 'App\Http\Controllers\BookController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1');
Route::resource('tasks', 'App\Http\Controllers\TaskController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1');
Route::resource('book_explanations', 'App\Http\Controllers\BookExplanationController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1');
Route::resource('task_explanations', 'App\Http\Controllers\TaskExplanationController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1');
Route::resource('our_targets', 'App\Http\Controllers\OurTargetController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1');

