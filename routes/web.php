<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\SpecialController;
use Illuminate\Support\Facades\Route;

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
    return view('landing');
})->name('home');

Route::get('/cities', function () {
    return view('cities');
})->name('cities');

Route::get('/collections', function () {
    return view('collections');
})->name('collections');

Route::get('/genres', function () {
    return view('genres');
})->name('genres');

Route::get('/specials', function () {
    return view('specials');
})->name('specials');

Route::post('/navbar', [NavbarController::class, 'index']);
Route::post('/collections', [CollectionController::class, 'index']);
Route::post('/collections/search', [CollectionController::class, 'search']);

Route::post('/new', [NewController::class, 'index']);
Route::post('/special', [SpecialController::class, 'index']);
Route::post('/news', [SpecialController::class, 'index']);
