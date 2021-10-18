<?php

use App\Http\Controllers\BookmarkShowController;
use App\Http\Controllers\HatenaBookmarkController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\DependencyInjection\RegisterControllerArgumentLocatorsPass;
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
Route::get('/hatena-show', [
    HatenaBookmarkController::class,
    "show"
])->middleware('auth');
Route::get('/hatena-show', [
    HatenaBookmarkController::class,
    "index"
])->middleware('auth');
Route::post('/hatena-show', [
    HatenaBookmarkController::class,
    "show"
])->middleware('auth');
Route::get('/show-comment', [
    BookmarkShowController::class,
    "show"
])->middleware('auth');
Route::get('/register', [
    RegisterController::class,
    "index"
])->middleware('auth');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
