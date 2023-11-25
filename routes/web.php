<?php

use App\Classes\Pagination;
use App\Classes\Vars;
use App\Http\Controllers\AdminCityController;
use App\Http\Controllers\AdminCollectionController;
use App\Http\Controllers\AdminCommentController;
use App\Http\Controllers\AdminGenreController;
use App\Http\Controllers\AdminLearnController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConfirmNumberController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SiteVariablesController;
use App\Http\Controllers\SpecialRoomCotroller;
use App\Http\Controllers\SpecificMediaController;
use App\Http\Controllers\VoteController;
use \App\Http\Controllers\CustomPriceController;
use \App\Http\Controllers\CheckoutController;
use \App\Http\Controllers\MyRoomController;
use App\Models\Room;
use App\Models\SiteVariables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HourController;
use \App\Http\Controllers\HourTypeController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\ReservationController;
use \App\Http\Controllers\MovieController;
use \App\Http\Controllers\NewsController;
use \App\Http\Controllers\TagContoller;
use \App\Models\Tag;
use \App\Http\Middleware\AuthorizeSuperUser;
use \App\Http\Controllers\MultimediaController;


Route::view('/', 'landing')->name('home');
Route::view('/login', 'login')->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('postLogin');
Route::post('/get-credentials', [LoginController::class, 'getCredentials']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');
Route::get('/logout', [LoginController::class, 'logoutAndRedirect']);
Route::post('/auth-check', [LoginController::class, 'checkLogin']);
Route::post('/get-confirm-number', [ConfirmNumberController::class, 'getConfirmNumber']);
Route::post('/submit-confirm-code', [ConfirmNumberController::class, 'submitConfirmCode']);
Route::post('/vote/{type}/comment/{comment}', [VoteController::class, 'submitVote']);
Route::get('/phone-check/{backUrl}', function ($backUrl) {

    if (Auth::check()) {
        return redirect('/');
    }

    return view('phone-check', ['backUrl' => $backUrl]);
});
Route::view('/cities', 'cities')->name('cities');
Route::view('/collections', 'collections')->name('collections');
Route::view('/rooms', 'room_search')->name('roomSearch');
Route::view('/learn', 'learnings')->name('learnings');
Route::view('/movies', 'movies')->name('movies');
Route::view('/news', 'news')->name('news');

Route::get('/dashboard', function () {
    return view('dashboard', [
        'user' => json_encode(Auth::user()->only(['id', 'name', 'email', 'type'])),
        'tags' => json_encode(Tag::select('id', 'name')->get())
    ]);

})->name('dashboard')->middleware('auth.admin');;

Route::get('/about-us', function () {
    $aboutUs = SiteVariables::whereVariable('our_story_text')->first()->value;
    return view('about_us', ['aboutUs' => $aboutUs]);
});

Route::get('/contact-us', function () {
    $contactUs = SiteVariables::whereVariable('contact_us')->first()->value;
    return view('contact_us', ['contactUs' => $contactUs]);
});

Route::get('/learn/{id}', function ($id) {
    return view('learning', ['id' => $id]);
})->name('learnShow');

Route::get('/movie/{id}', function ($id) {
    return view('movie', ['id' => $id]);
})->name('movieShow');

Route::get('/news/{id}', function ($id) {
    return view('single-news', ['id' => $id]);
})->name('newsShow');

Route::get('/rooms/{room}', function ($room) {
    $room = Room::whereDisabled(0)->findOrFail($room);
    $room->page_views = $room->page_views + 1;
    $room->save();
    return view('room_show', ['id' => $room->id]);
})->name('roomShow');

Route::get('/checkout/{roomId}', function ($roomId) {

    $room = Room::whereReservable(1)->findOrFail($roomId);
    return view('checkout', ['roomId' => $roomId]);
});
Route::get('/special-rooms/{roomType?}', function ($roomType = 'special') {
    return view('special_rooms', ['roomType' => $roomType]);
});

Route::post('movies', [MovieController::class, 'actionDispatcher']);
Route::post('news', [NewsController::class, 'actionDispatcher']);
Route::post('tags', [TagContoller::class, 'actionDispatcher']);
Route::post('multimedia', [MultimediaController::class, 'actionDispatcher']);

Route::get('/checkout/payment-callback/{room}/{payment}/{amount}', [CheckoutController::class, 'paymentCallBack']);
Route::get('/checkout/comment/{reservation}', [CheckoutController::class, 'commentingAfterCheckout']);

Route::get('/insert-comment/{room}', [RoomController::class, 'insertComment'])->middleware('auth.withNumber');
Route::get('/edit-comment/{comment}', [RoomController::class, 'editComment'])->middleware('auth.withNumber');
Route::post('/submit-comment', [CommentController::class, 'submitComment']);
Route::post('/edit-comment/{room}', [CommentController::class, 'editComment']);

Route::post('/navbar', [NavbarController::class, 'index']);
Route::post('/cities', [CitiesController::class, 'index']);
Route::post('/posts', [PostController::class, 'index']);
Route::post('/posts/starred', [PostController::class, 'starred']);
Route::post('/getCollections', [CollectionController::class, 'index']);
//Route::post('/collections/search', [CollectionController::class, 'search']);
Route::post('/collections/logos', [CollectionController::class, 'logos']);
Route::post('/learn/{post}', [PostController::class, 'show']);
Route::post('/rooms/complicated-search', [RoomController::class, 'complicatedSearch']);
Route::post('/rooms/complicated-rooms', [RoomController::class, 'complicatedRooms']);
Route::post('/rooms/{room}', [RoomController::class, 'show']);
Route::post('/rooms/{room}/comments', [RoomController::class, 'comments']);
Route::post('/rooms/landing/search', [RoomController::class, 'landingSearch']);
Route::post('/comments/{comment}/answers', [CommentController::class, 'answers']);
Route::post('/comments/{comment}/answer', [CommentController::class, 'answerToComment']);
Route::post('special-rooms/special', [SpecialRoomCotroller::class, 'special']);
Route::post('special-rooms/new', [SpecialRoomCotroller::class, 'new']);
Route::post('special-rooms/discount', [SpecialRoomCotroller::class, 'discount']);
Route::get('/room-Description', [RoomController::class, 'roomDescription']);

Route::post('/specific-medias/first-page-medias', [SpecificMediaController::class, 'getFirstPageMedias']);
Route::post('/specific-medias/get-carousel-medias', [SpecificMediaController::class, 'getCarouselMedias']);

Route::post('site-vars', [SiteVariablesController::class, 'index']);
Route::post('site-vars/first-page', [SiteVariablesController::class, 'getFirstPageVars']);
Route::post('site-vars/special-rooms', [SiteVariablesController::class, 'getSpecialRoomsVars']);
Route::post('site-vars/cities-page', [SiteVariablesController::class, 'getCitiesPageVars']);
Route::post('site-vars/collections-page', [SiteVariablesController::class, 'getCollectionsPageVars']);
Route::post('site-vars/genres-page', [SiteVariablesController::class, 'getGenresPageVars']);
Route::post('site-vars/learnings-page', [SiteVariablesController::class, 'getLearningsPageVars']);
Route::post('/site-vars/movies-page', [SiteVariablesController::class, 'getMoviesPageVars']);
Route::post('/site-vars/news-page', [SiteVariablesController::class, 'getNewsPageVars']);
Route::post('site-vars/rate-titles', [SiteVariablesController::class, 'rateTitles']);
Route::post('site-vars/{siteVariables}/attach-media/{media}', [SiteVariablesController::class, 'attachMedia']);
Route::post('site-vars/{siteVariables}/detach-media', [SiteVariablesController::class, 'detachMedia']);
Route::post('site-vars/upate', [SiteVariablesController::class, 'update']);

Route::post('days', [\App\Http\Controllers\DayController::class, 'index']);
Route::post('holiday-days', [\App\Http\Controllers\DayController::class, 'holidayDays']);

Route::post('user-roles/{id?}', [UserController::class, 'getUserAndRoles']);
Route::post('user-users', [UserController::class, 'getUserAndUsers']);
Route::post('custom-prices/search', [CustomPriceController::class, 'search']);
Route::post('reservation/get', [ReservationController::class, 'search']);
Route::post('hour-types/update', [HourTypeController::class, 'updateEntity']);

Route::resource('hours', HourController::class);
Route::resource('users', UserController::class);
Route::resource('custom-prices', CustomPriceController::class);
Route::resource('reservation', ReservationController::class);
Route::resource('checkout-process', CheckoutController::class);
Route::resource('my-rooms', MyRoomController::class);

Route::middleware([AuthorizeSuperUser::class])->group(function () {
    Route::resource('hour-types', HourTypeController::class);
    Route::post('add-holiday', [\App\Http\Controllers\DayController::class, 'addHoliday']);
    Route::post('delete-holiday/{holidayType}', [\App\Http\Controllers\DayController::class, 'deleteHoliday']);
    Route::post('add-holiday-day/{holidayType}', [\App\Http\Controllers\DayController::class, 'addHolidayDay']);
});


Route::prefix('admin')->group(function () {

    Route::middleware([AuthorizeSuperUser::class])->group(function () {

        Route::prefix('city')->group(function () {
            Route::post('', [AdminCityController::class, 'index']);
            Route::post('/search', [AdminCityController::class, 'search']);
            Route::post('/store', [AdminCityController::class, 'store']);
            Route::post('/delete', [AdminCityController::class, 'delete']);
            Route::get('/update/{city}', [AdminCityController::class, 'update']);
            Route::post('/update/{city}', [AdminCityController::class, 'change']);
            Route::post('/detach-media/{city}', [AdminCityController::class, 'detachMedia']);
            Route::post('{city}/attach-media/{media}', [AdminCityController::class, 'attachMedia']);
        });

        Route::prefix('collection')->group(function () {
            Route::post('', [AdminCollectionController::class, 'index']);
            Route::post('/search', [AdminCollectionController::class, 'search']);
            Route::post('/store', [AdminCollectionController::class, 'store']);
            Route::post('/delete', [AdminCollectionController::class, 'delete']);
            Route::get('/update/{collection}', [AdminCollectionController::class, 'update']);
            Route::post('/update/{collection}', [AdminCollectionController::class, 'change']);
            Route::post('/detach-media/{collection}', [AdminCollectionController::class, 'detachMedia']);
            Route::post('{collection}/attach-media/{media}', [AdminCollectionController::class, 'attachMedia']);
        });

        Route::prefix('genre')->group(function () {
            Route::post('', [AdminGenreController::class, 'index']);
            Route::post('/search', [AdminGenreController::class, 'search']);
            Route::post('/store', [AdminGenreController::class, 'store']);
            Route::post('/delete', [AdminGenreController::class, 'delete']);
            Route::get('/update/{genre}', [AdminGenreController::class, 'update']);
            Route::post('/update/{genre}', [AdminGenreController::class, 'change']);
            Route::post('/detach-media/{genre}', [AdminGenreController::class, 'detachMedia']);
            Route::post('{genre}/attach-media/{media}', [AdminGenreController::class, 'attachMedia']);
        });

        Route::prefix('learn')->group(function () {
            Route::post('', [AdminLearnController::class, 'index']);
            Route::post('/search', [AdminLearnController::class, 'search']);
            Route::post('/store', [AdminLearnController::class, 'store']);
            Route::post('/delete', [AdminLearnController::class, 'delete']);
            Route::get('/update/{post}', [AdminLearnController::class, 'update']);
            Route::post('/update/{post}', [AdminLearnController::class, 'change']);
            Route::post('/detach-media/{post}', [AdminLearnController::class, 'detachMedia']);
            Route::post('{post}/attach-media/{media}', [AdminLearnController::class, 'attachMedia']);
        });

        Route::prefix('specific-medias')->group(function () {
            Route::post('{specificMedia}/attach-media/{media}', [SpecificMediaController::class, 'attachStaticMedia']);
            Route::post('{specificMedia}/attach-dynamic-media/{media}', [SpecificMediaController::class, 'attachDynamicMedia']);
            Route::post('attach-media/{media}', [SpecificMediaController::class, 'createDynamicMedia']);
            Route::post('detach-static-media/{specificMedia}', [SpecificMediaController::class, 'detachStaticMedia']);
            Route::post('detach-dynamic-media/{specificMedia}', [SpecificMediaController::class, 'detachDynamicMedia']);
            Route::post('get-medias', [SpecificMediaController::class, 'getMedias']);
        });

        Route::prefix('media')->group(function () {
            Route::post('', [MediaController::class, 'index']);
            Route::post('/search', [MediaController::class, 'search']);
            Route::post('/filter', [MediaController::class, 'filter']);
            Route::post('/upload', [MediaController::class, 'upload']);
            Route::post('/delete', [MediaController::class, 'delete']);
            Route::post('/modal', [MediaController::class, 'modal']);
        });

        Route::prefix('room')->group(function () {
            Route::post('', [AdminRoomController::class, 'index']);
            Route::post('/do', [AdminRoomController::class, 'do']);
            Route::post('/store', [AdminRoomController::class, 'store']);
            Route::get('/update/{room}', [AdminRoomController::class, 'update']);
            Route::post('/update/{room}', [AdminRoomController::class, 'change']);
            Route::post('/dependencies', [AdminRoomController::class, 'getDependencies']);
            Route::post('/room-dependency', [AdminRoomController::class, 'getRoomDependency']);
            Route::post('/detach-media/{room}', [AdminRoomController::class, 'detachMedia']);
            Route::post('{room}/attach-media/{media}', [AdminRoomController::class, 'attachMedia']);
        });

    });

    Route::prefix('comment')->group(function () {
        Route::post('', [AdminCommentController::class, 'index']);
        Route::post('search', [AdminCommentController::class, 'search']);
        Route::post('delete', [AdminCommentController::class, 'delete'])->middleware(AuthorizeSuperUser::class);
        Route::post('grant', [AdminCommentController::class, 'grant'])->middleware(AuthorizeSuperUser::class);
    });
});
