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

Route::resource('targets', 'App\Http\Controllers\TargetController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']]);
Route::resource('ideas', 'App\Http\Controllers\IdeaController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']]);
Route::resource('private_categories', 'App\Http\Controllers\PrivateCategoryController', ['only' => ['index', 'create', 'store', 'edit', 'destroy', 'update']]);