<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SpecialController;
use App\Http\Resources\rooms\RoomForRoomPageResource;
use App\Models\Room;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('home');
Route::view('/cities','cities')->name('cities');
Route::view('/collections','collections')->name('collections');
Route::view('/genres','room_search')->name('roomSearch');
Route::view('/specials','specials')->name('specials');

Route::get('/rooms/{id}', function($id){
    return view('room_show',['id'=>$id]);
})->name('roomShow');

Route::post('/navbar', [NavbarController::class, 'index']);
Route::post('/collections', [CollectionController::class, 'index']);
Route::post('/collections/search', [CollectionController::class, 'search']);
Route::post('/rooms/complicated-search', [RoomController::class, 'complicatedSearch']);
Route::post('/rooms/{room}', [RoomController::class, 'show']);

Route::post('/new', [NewController::class, 'index']);
Route::post('/special', [SpecialController::class, 'index']);
Route::post('/news', [SpecialController::class, 'index']);
