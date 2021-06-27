<?php

use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SpecialRoomCotroller;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('home');
Route::view('/cities','cities')->name('cities');
Route::view('/collections','collections')->name('collections');
Route::view('/genres','room_search')->name('roomSearch');
Route::view('/learn','learnings')->name('learnings');

Route::view('/dashboard', 'dashboard')->name('dashboard');

Route::get('/learn/{id}', function($id){
    return view('learning',['id'=>$id]);
})->name('roomShow');

Route::get('/rooms/{id}', function($id){
    return view('room_show',['id'=>$id]);
})->name('roomShow');

Route::post('/navbar', [NavbarController::class, 'index']);
Route::post('/cities', [CitiesController::class, 'index']);
Route::post('/posts', [PostController::class, 'index']);
Route::post('/posts/starred', [PostController::class, 'starred']);
Route::post('/collections', [CollectionController::class, 'index']);
Route::post('/collections/search', [CollectionController::class, 'search']);
Route::post('/collections/logos', [CollectionController::class, 'logos']);
Route::post('/learn/{post}', [PostController::class, 'show']);
Route::post('/rooms/complicated-search', [RoomController::class, 'complicatedSearch']);
Route::post('/rooms/{room}', [RoomController::class, 'show']);
Route::post('/rooms/{room}/comments', [RoomController::class, 'comments']);
Route::post('/comments/{comment}/answers', [CommentController::class, 'answers']);
Route::post('special-rooms/special', [SpecialRoomCotroller::class, 'special']);
Route::post('special-rooms/new', [SpecialRoomCotroller::class, 'new']);
Route::post('special-rooms/discount', [SpecialRoomCotroller::class, 'discount']);
Route::get('/room-Description', [RoomController::class, 'roomDescription']);

Route::prefix('admin')->group(function(){
    Route::post('media',[ MediaController::class, 'index']);
    Route::post('/media/search',[ MediaController::class, 'search']);
    Route::post('/media/filter',[ MediaController::class, 'filter']);
    Route::post('/media/upload',[ MediaController::class, 'upload']);
});
