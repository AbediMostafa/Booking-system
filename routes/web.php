<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SpecialController;
use Illuminate\Support\Facades\Route;

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
    return view('room_search');
})->name('roomSearch');

Route::get('/specials', function () {
    return view('specials');
})->name('specials');

Route::post('/navbar', [NavbarController::class, 'index']);
Route::post('/collections', [CollectionController::class, 'index']);
Route::post('/collections/search', [CollectionController::class, 'search']);
Route::post('/rooms/complicated-search', [RoomController::class, 'complicatedSearch']);

Route::post('/new', [NewController::class, 'index']);
Route::post('/special', [SpecialController::class, 'index']);
Route::post('/news', [SpecialController::class, 'index']);
