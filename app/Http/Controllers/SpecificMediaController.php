<?php

namespace App\Http\Controllers;

use App\Http\Resources\specific_medias\AdminSpecificMediaResource;
use App\Models\Media;
use App\Models\SpecificMedia;
use Illuminate\Http\Request;

class SpecificMediaController extends Controller
{

    public function attachStaticMedia(Request $request, SpecificMedia $specificMedia, Media $media)
    {
        try {

            $specificMedia->medias()->sync(
                [
                    $media->id => [
                        'place' => $request->input('type') === 'video' ? 'video' : 'front'
                    ]
                ]
            );

            return [
                'status' => true,
                'msg' => 'مدیا با موفقیت اضافه شد.'
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'msg' => 'مشکل در اضافه کردن مدیا'
            ];
        }
    }

    public function attachDynamicMedia(SpecificMedia $specificMedia, Media $media)
    {
        try {
            $specificMedia->medias()->sync($media);

            return [
                'status' => true,
                'msg' => 'مدیا با موفقیت تعویض شد.',
                'sm_id' => $specificMedia->id
            ];

        }catch (\Throwable $th){
            return [
                'status' => false,
                'msg' => 'مشکل در اضافه کردن مدیا'
            ];
        }
    }

    public function createDynamicMedia(Request $request, Media $media)
    {

        $request->validate([
            'roomId'=>'nullable|exists:rooms,id'
        ]);

        try {
            $specificMedia = SpecificMedia::create([
                'name' => 'banner_slider',
                'room_id'=>$request->input('roomId')
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
        try {
            $specificMedia->delete();

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

        foreach (SpecificMedia::where('name', 'banner_slider')->get() as $specificMedia) {
            $media = $specificMedia->medias()->first();
            $medias[] = [
                'media'=>$media ? $media->path : '',
                'roomId'=>$specificMedia->room ? $specificMedia->room->id:''
            ];
        }

        return $medias;
    }
}
