<?php

use App\Http\Controllers\AdminCityController;
use App\Http\Controllers\AdminCollectionController;
use App\Http\Controllers\AdminGenreController;
use App\Http\Controllers\AdminLearnController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SpecialRoomCotroller;
use App\Http\Controllers\SpecificMediaController;
use App\Models\City;
use App\Models\Collection;
use App\Models\Genre;
use App\Models\Media;
use App\Models\Post;
use App\Models\Room;
use App\Models\SpecificMedia;
use Illuminate\Support\Facades\Route;
use Morilog\Jalali\Jalalian;

Route::view('/', 'landing')->name('home');

Route::get('test', function(){
    
    dd(SpecificMedia::all()->where('name', 'banner_slider')->all());

    
    dd(
        SpecificMedia::where('name', 'banner_slider')->with('medias')->get()->pluck('medias')
    );
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

Route::post('/specific-medias/first-page-medias', [SpecificMediaController::class, 'getFirstPageMedias']);

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
        Route::post('/store',[ AdminCityController::class, 'store']);
        Route::post('/delete',[ AdminCityController::class, 'delete']);
        Route::get('/update/{city}',[ AdminCityController::class, 'update']);
        Route::post('/update/{city}',[ AdminCityController::class, 'change']);
        Route::post('/detach-media/{media}',[ AdminCityController::class, 'detachMedia']);
        Route::post('{city}/attach-media/{media}',[ AdminCityController::class, 'attachMedia']);
    });

    Route::prefix('collection')->group(function(){
        Route::post('',[ AdminCollectionController::class, 'index']);
        Route::post('/search',[ AdminCollectionController::class, 'search']);
        Route::post('/store',[ AdminCollectionController::class, 'store']);
        Route::post('/delete',[ AdminCollectionController::class, 'delete']);
        Route::get('/update/{collection}',[ AdminCollectionController::class, 'update']);
        Route::post('/update/{collection}',[ AdminCollectionController::class, 'change']);
        Route::post('/detach-media/{media}',[ AdminCollectionController::class, 'detachMedia']);
        Route::post('{collection}/attach-media/{media}',[ AdminCollectionController::class, 'attachMedia']);
    });

    Route::prefix('genre')->group(function(){
        Route::post('',[ AdminGenreController::class, 'index']);
        Route::post('/search',[ AdminGenreController::class, 'search']);
        Route::post('/store',[ AdminGenreController::class, 'store']);
        Route::post('/delete',[ AdminGenreController::class, 'delete']);
        Route::get('/update/{genre}',[ AdminGenreController::class, 'update']);
        Route::post('/update/{genre}',[ AdminGenreController::class, 'change']);
        Route::post('/detach-media/{media}',[ AdminGenreController::class, 'detachMedia']);
        Route::post('{genre}/attach-media/{media}',[ AdminGenreController::class, 'attachMedia']);
    });

    Route::prefix('learn')->group(function(){
        Route::post('',[ AdminLearnController::class, 'index']);
        Route::post('/search',[ AdminLearnController::class, 'search']);
        Route::post('/store',[ AdminLearnController::class, 'store']);
        Route::post('/delete',[ AdminLearnController::class, 'delete']);
        Route::get('/update/{post}',[ AdminLearnController::class, 'update']);
        Route::post('/update/{post}',[ AdminLearnController::class, 'change']);
        Route::post('/detach-media/{media}',[ AdminLearnController::class, 'detachMedia']);
        Route::post('{post}/attach-media/{media}',[ AdminLearnController::class, 'attachMedia']);
    });

    Route::prefix('specific-medias')->group(function(){
        Route::post('attach-media', [SpecificMediaController::class, 'attachMedia']);
        Route::post('detach-static-media/{media}', [SpecificMediaController::class, 'detachStaticMedia']);
        Route::post('detach-dynamic-media/{media}', [SpecificMediaController::class, 'detachDynamicMedia']);
        Route::post('get-medias', [SpecificMediaController::class, 'getMedias']);
    });

});