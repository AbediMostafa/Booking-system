<?php

namespace App\Http\Controllers;

use App\Classes\Pagination;
use App\Http\Resources\collections\AdminCollectionResource;
use App\Models\Collection;
use App\Models\Media;
use Illuminate\Http\Request;

class AdminCollectionController extends Controller
{
    public function index()
    {
        return AdminCollectionResource::collection(Collection::paginate(Pagination::$dashboardEntity));
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

        return tryCatch(function (){
            Collection::destroy(\request('collections'));
        },'مجموعه ها با موفقیت حذف شدند.','مشکل در حذف مجموعه ها');
    }

    public function update(Collection $collection)
    {

        $media = $collection->mediaType()->first();
        return [
            'collectionName' => $collection->title,
            'collection' => $collection->only('id', 'title', 'collection_order'),
            'media' => [
                'background' => $media ? $media->path : '',
                'id' => $media ? $media->id : '',
            ]
        ];
    }

    public function detachMedia(Collection $collection)
    {
        $collection->medias()->detach();

        return [
            'status' => true,
            'msg' => 'حذف مدیا با موفقیت انجام شد.'
        ];
    }

    public function attachMedia(Collection $collection, Media $media)
    {

        $collection->medias()->sync($media);

        return [
            'status' => true,
            'msg' => 'مدیا با موفقیت اضافه شد'
        ];
    }

    public function change(Request $request, Collection $collection):array
    {
       return tryCatch(function () use($request, $collection){

            if($request->input('title')){
                $collection->title = $request->input('title');
            }
            if($request->input('collection_order')){
                $collection->collection_order = (int)$request->input('collection_order');
            }
            $collection->save();

        },'بروزرسانی با موفقیت انجام شد.','مشکل در بروزرسانی ');
    }

    public function store(Request $request)
    {
        $request->validate([
            'collection.name' => 'required',
            'media.id' => 'required|exists:media,id'
        ]);

        return tryCatch(function () use ($request) {

            $collection = Collection::create([
                'title' => $request->input('collection.name'),
                'collection_order' => (int)$request->input('collection.order')
            ]);

            $collection->medias()->attach($request->input('media.id'));

        }, 'مجموعه با موفقیت ایجاد شد', 'خطا در ایجاد مجموعه');
    }
}
