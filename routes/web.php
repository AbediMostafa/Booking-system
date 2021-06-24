<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SpecialRoomCotroller;
use App\Http\Resources\Rooms\CommentComments;
use App\Models\Comment;
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
Route::post('/rooms/{room}/comments', [RoomController::class, 'comments']);
Route::post('/comment/{comment}/replies', [CommentController::class, 'commentChilds']);

Route::post('special-rooms/special', [SpecialRoomCotroller::class, 'special']);
Route::post('special-rooms/new', [SpecialRoomCotroller::class, 'new']);
Route::post('special-rooms/discount', [SpecialRoomCotroller::class, 'discount']);
Route::post('/room-Description', [RoomController::class, 'roomDescription']);