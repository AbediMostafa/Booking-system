<?php

namespace App\Http\Controllers;

use App\Http\Resources\MyRoomResource;
use App\Http\Resources\Rooms\RoomDescriptionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isRoomOwner()) {
            return MyRoomResource::collection(Auth::user()->rooms()->get());
        }
    }
}
