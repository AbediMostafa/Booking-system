<?php

namespace App\Http\Controllers;

use App\Http\Resources\collections\AdminCollectionResource;
use App\Models\Collection;
use App\Models\Media;
use Illuminate\Http\Request;

class AdminCollectionController extends Controller
{
    public function index()
    {
        return AdminCollectionResource::collection(Collection::paginate(10));
    }

    public function search(Request $request)
    {
        return AdminCollectionResource::collection(
            Collection::where('title', 'like', '%' . $request->get('search') . '%')->paginate(10)
        );
    }

    public function delete(Request $request)
    {
        $request->validate([
            'collections' => 'required|array',
            'collections.*' => 'exists:collections,id',
        ]);

        $collections = Collection::whereIn('id', $request->get('collections'))->get();

        foreach ($collections as $collection) {
            if ($collection->rooms->count()) {
                return [
                    'status' => false,
                    'msg' => "مجموعه $collection->title اتاق هایی دارد و نمیتواند پاک شود"
                ];
            }
            $collection->delete();
        }
        try {

            return  [
                'status' => true,
                'msg' => 'مجموعه ها با موفقیت حذف شدند.'
            ];
        } catch (\Throwable $th) {

            return [
                'status' => false,
                'msg' => 'مشکل در حذف مجموعه ها'
            ];
        }
    }

    public function update(Collection $collection)
    {

        $media = $collection->medias()->first();
        return [
            'collectionName' => $collection->title,
            'collection' => $collection->only('id', 'title'),
            'media' => [
                'background' => $media ? $media->path : '',
                'id' => $media ? $media->id : '',
            ]
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

    public function attachMedia(Collection $collection, Media $media)
    {
        $media->media_of = 'collection';
        $media->place = 'front';
        $media->save();

        $collection->medias()->save($media);

        return [
            'status' => true,
            'msg' => 'مدیا با موفقیت اضافه شد'
        ];
    }

    public function change(Request $request, Collection $collection)
    {
        $collection->update([
            'title' => $request->input('title')
        ]);

        return [
            'status' => true,
            'msg' => 'بروزرسانی با موفقیت انجام شد.'
        ];
        try {
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'msg' => 'مشکل در بروزرسانی '
            ];
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'collection.name'=>'required',
            'media.id'=>'required|exists:media,id'
        ]);

        $collection = Collection::create([
            'title'=>$request->input('collection.name')
        ]);

        $media = Media::findOrFail($request->input('media.id'));
        $media->update([
            'media_of'=>'collection',
            'place'=>'front',
        ]);

        $collection->medias()->save($media);

        return[
            'status'=>true,
            'msg'=>'مجموعه با موفقیت ایجاد شد'
        ];
    }
}
