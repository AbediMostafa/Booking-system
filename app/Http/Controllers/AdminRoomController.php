<?php

namespace App\Http\Controllers;

use App\Classes\Pagination;
use App\Http\Requests\AdminRoomRequest;
use App\Http\Resources\rooms\AdminRoomResource;
use App\Http\Resources\rooms\AdminUpdateRoomResource;
use App\Models\City;
use App\Models\Collection;
use App\Models\ExtraHoliday;
use App\Models\Genre;
use App\Models\HolidayType;
use App\Models\HourType;
use App\Models\Media;
use App\Models\Room;
use App\Models\Tag;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class AdminRoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::when($request->get('search'), function ($room) {
            $room->where('name', 'like', '%' . \request('search') . '%');
        })->paginate(Pagination::$dashboardEntity);

        return AdminRoomResource::collection($rooms);
    }

    public function getDependencies()
    {
        return [
            'collections' => Collection::select('title as text', 'id')->get(),
            'cities' => City::select('id', 'name as text')->get(),
            'genres' => Genre::select('id', 'title as text')->get(),
            'holidayTypes' => HolidayType::select('id', 'name as text')->get(),
            'hourTypes' => HourType::select('id', 'name as text')->get(),
            'tags' => Tag::select('id', 'name')->get(),
        ];
    }

    public function getRoomDependency()
    {
        return Room::select('id', 'name as text')->get();
    }

    public function do()
    {
        \request()->validate([
            'roomIds' => 'required|array',
            'roomIds.*' => 'exists:rooms,id',
        ]);

        return $this->{\request('method')}();
    }

    public function actionDelete()
    {
        return tryCatch(function () {
            Room::destroy(\request('roomIds'));
        }, 'اتاق ها با موفقیت حذف شدند.', 'مشکل در حذف اتاق ها');
    }

    public function actionToggleDeactivation()
    {
        $msgType = \request('type') === 'disable' ? 'غیرفعال':'فعال';

        return tryCatch(function () {
            Room::whereIn('id', \request('roomIds'))
                ->update([
                    'disabled' => \request('type') === 'disable' ? 1 : 0
                ]);
        }, "اتاق ها با موفقیت $msgType شدند", "مشکل در $msgType  کردن اتاق ها ");
    }

    public function actionToggleReservation()
    {
        $msgType = \request('type') === 'disable' ? 'غیرفعال':'فعال';

        return tryCatch(function () {
            Room::whereIn('id', \request('roomIds'))
                ->update([
                    'reservable' => \request('type') === 'disable' ? 0 : 1
                ]);
        }, "رزرو اتاق ها با موفقیت $msgType شدند ", "مشکل در $msgType کردن رزرو اتاق ها");
    }

    public function store(AdminRoomRequest $request)
    {
        return tryCatch(function () use ($request) {
            $room = Room::create($request->get('room'));

            if ($request->get('hasDiscount')) {
                $this->addRoomDiscount($room);
            }

            $this->addRoomMedias($room);
            $room->genres()->attach($request->input('genreIds'));
            $room->tags()->attach($request->input('tagIds'));

        }, 'اتاق با موفقیت ایجاد شد.', 'مشکل در ایجاد اتاق.');
    }

    public function addRoomMedias($room)
    {
        if (request()->input('medias')) {
            foreach (request()->input('medias') as $type => $media) {
                if (empty($media)) {
                    continue;
                }

                $room->mediaType($type)->attach([
                    $media['id'] => ['place' => $type]
                ]);
            }
        }
    }

    public function convertDiscountDateToJalalian()
    {
        return [
            'started_at' => Jalalian::fromFormat('Y/m/d', request()->input('discount.started_at'))
                ->toCarbon()
                ->toDateTimeString(),
            'ended_at' => Jalalian::fromFormat('Y/m/d', request()->input('discount.ended_at'))
                ->toCarbon()
                ->toDateTimeString()
        ];
    }

    public function addRoomDiscount($room)
    {
        $dates = $this->convertDiscountDateToJalalian();

        $room->discount()->create([
            'started_at' => $dates['started_at'],
            'ended_at' => $dates['ended_at'],
            'amount' => request()->input('discount.amount')
        ]);
    }

    public function update(Room $room)
    {
        return new AdminUpdateRoomResource($room);
    }

    public function change(AdminRoomRequest $request, Room $room)
    {
        $room->update($request->input('room'));
        $room->genres()->sync($request->input('genreIds'));
        $room->tags()->sync($request->input('tagIds'));

        if ($request->input('hasDiscount')) {
            $dates = $this->convertDiscountDateToJalalian();

            $queryType = $room->discount ? 'update' : 'create';

            $room->discount()->{$queryType}([
                'amount' => $request->input('discount.amount'),
                'started_at' => $dates['started_at'],
                'ended_at' => $dates['ended_at'],
            ]);
        } else {
            $room->discount()->delete();
        }

        return [
            'status' => true,
            'msg' => 'بروزرسانی با موفقیت انجام شد.'
        ];
    }

    public function detachMedia(Request $request, Room $room)
    {
        $room->mediaType($request->input('type'))->detach();

        return [
            'status' => true,
            'msg' => 'حذف مدیا با موفقیت انجام شد.'
        ];
    }

    public function attachMedia(Request $request, Room $room, Media $media)
    {
        $room->mediaType($request->input('place'))->sync(
            [$media->id => [
                'place' => $request->input('place')
            ]]
        );

        return [
            'status' => true,
            'msg' => 'مدیا با موفقیت اضافه شد'
        ];
    }
}
