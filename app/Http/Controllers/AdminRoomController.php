<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRoomRequest;
use App\Http\Resources\rooms\AdminRoomResource;
use App\Http\Resources\rooms\AdminUpdateRoomResource;
use App\Models\City;
use App\Models\Collection;
use App\Models\Genre;
use App\Models\Media;
use App\Models\Room;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class AdminRoomController extends Controller
{
    public function index()
    {
        return AdminRoomResource::collection(Room::paginate(12));
    }

    public function search(Request $request)
    {
        return AdminRoomResource::collection(
            Room::where('name', 'like', '%' . $request->get('search') . '%')->paginate(12)
        );
    }

    public function getDependencies()
    {
        return [
            'collections' => Collection::select('title as text', 'id')->get(),
            'cities' => City::select('id', 'name as text')->get(),
            'genres'=>Genre::select('id', 'title as text')->get()
        ];
    }

    public function delete(Request $request)
    {
        $request->validate([
            'roomIds' => 'required|array',
            'roomIds.*' => 'exists:rooms,id',
        ]);

        try {
            Room::whereIn('id', $request->get('roomIds'))->get()->each(function ($room) {
                $room->delete();
            });

            return  [
                'status' => true,
                'msg' => 'اتاق ها با موفقیت حذف شدند.'
            ];
        } catch (\Throwable $th) {

            return [
                'status' => false,
                'msg' => 'مشکل در حذف اتاق ها'
            ];
        }
    }

    public function store(AdminRoomRequest $request)
    {

        try {
            $room = Room::create($request->get('room'));
            if ($request->get('hasDiscount')) {
                $this->addRoomDiscount($room);
            }
            $this->addRoomMedias($room);
            
            $room->genres()->attach($request->input('genreIds'));

            return  [
                'status' => true,
                'msg' => 'اتاق با موفقیت ایجاد شد.'
            ];
        } catch (\Throwable $th) {
            return  [
                'status' => true,
                'msg' => 'مشکل در ایجاد اتاق.'
            ];
        }
    }

    public function addRoomMedias($room)
    {
        if (request()->input('medias')) {

            foreach (request()->input('medias') as $media) {

                if (empty($media)) {
                    continue;
                }

                $mediaModel = tap(Media::find($media['id']))->update([
                    'type' => $media['type'],
                    'place' => $media['place'],
                    'media_of' => 'room',
                ]);

                $room->medias()->save($mediaModel);
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
        $room->genres()->detach();
        $room->genres()->attach($request->input('genreIds'));

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

    public function detachMedia(Media $media)
    {
        $media->media_of = 'other';
        $media->place = 'other';
        $media->mediaable_id = null;
        $media->mediaable_type = null;
        $media->save();

        return [
            'status' => true,
            'msg' => 'حذف مدیا با موفقیت انجام شد.'
        ];
    }

    public function attachMedia(Request $request, Room $room, Media $media)
    {

        $previousMediaQuery = $room->medias()->where('place', $request->input('place'));
        $previousMedia = $previousMediaQuery->first();

        if ($previousMedia) {
            $previousMediaQuery->update([
                'media_of' => 'other',
                'place' => 'other',
                'mediaable_id' => null,
                'mediaable_type' => null,
            ]);
        }

        $mediaModel = tap($media)->update([
            'type' => $request->input('type'),
            'place' => $request->input('place'),
            'media_of' => 'room',
        ]);

        $room->medias()->save($mediaModel);

        return [
            'status' => true,
            'msg' => 'مدیا با موفقیت اضافه شد'
        ];
    }
}
