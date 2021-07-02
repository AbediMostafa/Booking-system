<?php

use App\Http\Controllers\AdminCityController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SpecialRoomCotroller;
use App\Models\Collection;
use App\Models\Media;
use App\Models\Room;
use Illuminate\Support\Facades\Route;
use Morilog\Jalali\Jalalian;

Route::view('/', 'landing')->name('home');

Route::get('test', function(){
        if(Room::find(42)->medias->count()){
            return 'has';
        }


});
Route::view('/cities','cities')->name('cities');
Route::view('/collections','collections')->name('collections');
Route::view('/genres','room_search')->name('roomSearch');
Route::view('/learn','learnings')->name('learnings');

Route::view('/dashboard', 'dashboard')->name('dashboard');

Route::get('/learn/{id}', function($id){
    return view('learning',['id'=>$id]);
})->name('learnShow');

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
    Route::prefix('media')->group(function(){
        Route::post('',[ MediaController::class, 'index']);
        Route::post('/search',[ MediaController::class, 'search']);
        Route::post('/filter',[ MediaController::class, 'filter']);
        Route::post('/upload',[ MediaController::class, 'upload']);
        Route::post('/delete',[ MediaController::class, 'delete']);
        Route::post('/modal',[ MediaController::class, 'modal']);
    });
    Route::prefix('room')->group(function(){
        Route::post('',[ AdminRoomController::class, 'index']);
        Route::post('/search',[ AdminRoomController::class, 'search']);
        Route::post('/delete',[ AdminRoomController::class, 'delete']);
        Route::post('/store',[ AdminRoomController::class, 'store']);
        Route::get('/update/{room}',[ AdminRoomController::class, 'update']);
        Route::post('/update/{room}',[ AdminRoomController::class, 'change']);
        Route::post('/dependencies',[ AdminRoomController::class, 'getDependencies']);
        Route::post('/detach-media/{media}',[ AdminRoomController::class, 'detachMedia']);
        Route::post('{room}/attach-media/{media}',[ AdminRoomController::class, 'attachMedia']);
    });
    Route::prefix('city')->group(function(){
        Route::post('',[ AdminCityController::class, 'index']);
        Route::post('/search',[ AdminCityController::class, 'search']);
        Route::post('/delete',[ AdminCityController::class, 'delete']);
    });
});