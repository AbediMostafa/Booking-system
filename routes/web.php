<?php

use App\Http\Controllers\DiscountController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PPostController;
use App\Http\Controllers\SpecialController;
use App\Models\Discount;
use App\Models\Room;
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
});

Route::get('/new',[NewController::class,'index']);
Route::post('/special',[SpecialController::class,'index']);
Route::get('/post',[PostController::class,'index']);
Route::get('/discount',[DiscountController::class,'index']);


