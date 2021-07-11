<?php

namespace App\Http\Controllers;

use App\Http\Resources\specific_medias\AdminSpecificMediaResource;
use App\Models\Media;
use App\Models\SpecificMedia;
use Illuminate\Http\Request;

class SpecificMediaController extends Controller
{

    public function attachStaticMedia(SpecificMedia $specificMedia, Media $media)
    {
        try {
            if ($specificMedia->medias()->exists()) {
                $specificMedia->medias()->first()->update([
                    'mediaable_id' => null,
                    'mediaable_type' => null,
                    'media_of' => 'other',
                ]);
            }

            $specificMedia->medias()->save($media);
            $media->media_of = 'specific_media';
            $media->save();

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
    public function attachDynamicMedia(Media $media)
    {
        try {

            $specificMedia = SpecificMedia::create([
                'name' => 'banner_slider'
            ]);

            $specificMedia->medias()->save($media);
            $media->media_of = 'specific_media';
            $media->save();

            return [
                'status' => true,
                'msg' => 'مدیا با موفقیت اضافه شد.',
                'sm_id'=>$specificMedia->id
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'msg' => 'مشکل در اضافه کردن مدیا'
            ];
        }
    }

    public function attachMedia(Request $request)
    {

        $request->validate([
            'media_id' => 'exists:media,id'
        ]);


        try {

            $media = Media::findOrFail($request->input('media_id'));
            $media->media_of = 'specific_media';
            $media->save();

            if ($request->input('type') == 'static') {
                $specificMedia = SpecificMedia::where('name', $request->input('key'))->first();

                if ($specificMedia->medias()->exists()) {
                    $specificMedia->medias()->first()->update([
                        'mediaable_id' => null,
                        'mediaable_type' => null,
                        'media_of' => 'other',
                    ]);
                }

                $specificMedia->medias()->save($media);
            } else {

                $specificMedia = SpecificMedia::create([
                    'name' => 'banner_slider'
                ]);

                $specificMedia->medias()->save($media);

                return [
                    'status' => true,
                    'msg' => 'مدیا با موفقیت اضافه شد.',
                    'sm_id' => $specificMedia->id
                ];
            }


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

    public function getMedias()
    {
        return new AdminSpecificMediaResource(SpecificMedia::all());
    }

    public function detachStaticMedia(Media $media)
    {

        try {
            $this->removeMedia($media);
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
             
            $media = $specificMedia->medias()->first();

            if($media){
                $this->removeMedia($media);
            }

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

    public function removeMedia($media)
    {
        $media->update([
            'media_of' => 'other',
            'mediaable_id' => null,
            'mediaable_type' => null,
        ]);
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
            $medias[] = $media ? $media->path : '';
        }

        return $medias;
    }
}
