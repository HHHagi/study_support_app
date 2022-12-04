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
// Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('auth.register');
});

// Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::middleware(['verified'])->group(function (){
    
Route::get('/our_targets', [App\Http\Controllers\OurTargetController::class, 'index'])->middleware('throttle:10, 1');

Route::resource('targets', 'App\Http\Controllers\TargetController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1')->middleware('auth');
Route::resource('ideas', 'App\Http\Controllers\IdeaController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('auth');
Route::resource('private_categories', 'App\Http\Controllers\PrivateCategoryController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1')->middleware('auth');
Route::resource('books', 'App\Http\Controllers\BookController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1')->middleware('auth');
Route::resource('tasks', 'App\Http\Controllers\TaskController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1')->middleware('auth');
Route::resource('book_explanations', 'App\Http\Controllers\BookExplanationController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1')->middleware('auth');
Route::resource('task_explanations', 'App\Http\Controllers\TaskExplanationController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1')->middleware('auth');
Route::resource('our_targets', 'App\Http\Controllers\OurTargetController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1')->middleware('auth');
Route::resource('likes', 'App\Http\Controllers\LikeController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']])->middleware('throttle:10, 1')->middleware('auth');

// });