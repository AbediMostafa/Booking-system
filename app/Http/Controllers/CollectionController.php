<?php

namespace App\Http\Controllers;

use App\Classes\Pagination;
use App\Http\Resources\collections\CollectionLogosResource;
use App\Http\Resources\collections\RoomCollectionResource;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{

    /**
     * get all collections with room count
     */
    public function index(Request $request)
    {
        $collections = Collection::when($request->key, function ($collection) use($request){
            $collection->where('title', 'LIKE', "%$request->key%");
        })->orderBy('collection_order')->paginate(Pagination::$collectionPaginateCount);

        return RoomCollectionResource::collection($collections);
    }

    /**
     * search on collections
     */
//    public function search(Request $request)
//    {
//        return RoomCollectionResource::collection(Collection::where('title', 'LIKE', "%$request->key%")->get());
//    }

    public function logos()
    {
        return CollectionLogosResource::collection(Collection::has('medias')->get());
    }
}
