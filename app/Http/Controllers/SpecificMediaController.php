<?php

namespace App\Http\Controllers;

use App\Http\Resources\specific_medias\AdminSpecificMediaResource;
use App\Models\Media;
use App\Models\SiteVariables;
use App\Models\SpecificMedia;
use Illuminate\Http\Request;

class SpecificMediaController extends Controller
{

    public function attachStaticMedia(Request $request, SpecificMedia $specificMedia, Media $media)
    {
        return tryCatch(function () use ($specificMedia, $media, $request) {

            $specificMedia->medias()->sync(
                [$media->id => [
                    'place' => $request->input('type') === 'video' ? 'video' : 'front'
                ]]
            );
        }, 'مدیا با موفقیت اضافه شد.', 'مشکل در اضافه کردن مدیا');
    }

    public function attachDynamicMedia(SpecificMedia $specificMedia, Media $media)
    {
        return ifIsSuperUser(function () use ($specificMedia, $media) {
            try {
                $specificMedia->medias()->sync($media);

                if ($specificMedia->room_id !== (int)\request('roomId')) {
                    $specificMedia->room_id = (int)\request('roomId');
                    $specificMedia->save();
                }

                return [
                    'status' => true,
                    'msg' => 'مدیا با موفقیت تعویض شد.',
                    'sm_id' => $specificMedia->id
                ];

            } catch (\Throwable $th) {
                return [
                    'status' => false,
                    'msg' => 'مشکل در اضافه کردن مدیا'
                ];
            }
        });
    }

    public function createDynamicMedia(Request $request, Media $media)
    {

        $request->validate([
            'roomId' => 'nullable|exists:rooms,id'
        ]);


        try {
            $specificMedia = SpecificMedia::create([
                'name' => $request->input('place'),
                'room_id' => $request->input('roomId')
            ]);

            $specificMedia->medias()->attach($media);

            return [
                'status' => true,
                'msg' => 'مدیا با موفقیت اضافه شد.',
                'sm_id' => $specificMedia->id
            ];

        } catch (\Throwable $th) {
            return [
                'status' => false,
                'msg' => 'مشکل در اضافه کردن مدیا'
            ];
        }
    }

    public function getMedias()
    {
        return new AdminSpecificMediaResource(SpecificMedia::with('room')->get());
    }

    public function detachStaticMedia(SpecificMedia $specificMedia)
    {
        try {
            $specificMedia->medias()->detach();

            return [
                'status' => true,
                'msg' => 'مدیا با موفقیت حذف شد'
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'msg' => 'مشکل در حذف کردن مدیا'
            ];
        }
    }

    public function detachDynamicMedia(SpecificMedia $specificMedia)
    {
        return ifIsSuperUser(function () use ($specificMedia) {
            return tryCatch(function () use ($specificMedia) {
                $specificMedia->delete();
            }, 'مدیا با موفقیت حذف شد', 'مشکل در حذف کردن مدیا');
        });
    }

    public function getFirstPageMedias(Request $request)
    {
        $media = SpecificMedia::where('name', $request->input('type'))
            ->first()
            ->medias()
            ->first();

        return $media ? $media->path : '';
    }

    public function getCarouselMedias()
    {
        $medias = [];

        $specificMedias = SpecificMedia::where('name', 'banner_slider')
            ->whereHas('room', function ($room) {
                $room->whereDisabled(0);
            })->get();

        foreach ($specificMedias as $specificMedia) {
            $media = $specificMedia->medias()->first();
            $medias[] = [
                'media' => $media ? $media->path : '',
                'roomId' => $specificMedia->room ? $specificMedia->room->id : ''
            ];
        }

        $titles = SiteVariables::where('variable', 'like', 'first_page_our_suggestion%')->get();
        $title = $titles->where('variable', 'first_page_our_suggestion_title')->first() ?
            $titles->where('variable', 'first_page_our_suggestion_title')->first()->value : '';
        $text = $titles->where('variable', 'first_page_our_suggestion_text')->first() ?
            $titles->where('variable', 'first_page_our_suggestion_text')->first()->value : '';

        return [
            'medias' => $medias,
            'title' => $title,
            'text' => $text,
        ];
    }
}
