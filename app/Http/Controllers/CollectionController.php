<?php

namespace App\Http\Controllers;

use App\Http\Resources\collections\CollectionLogosResource;
use App\Http\Resources\collections\RoomCollectionResource;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    
    /**
     * get all collections with room count
     */
    public function index()
    {
        return RoomCollectionResource::collection(Collection::all());
    }
    
    /**
     * search on collections
     */
    public function search(Request $request)
    {
        return RoomCollectionResource::collection(Collection::where('title', 'LIKE', "%$request->key%")->get());
    }

    public function logos()
    {
        return CollectionLogosResource::collection(Collection::all());
    }
}
