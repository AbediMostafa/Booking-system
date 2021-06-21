<?php

namespace App\Http\Controllers;

use App\Http\Resources\rooms\SpecialRoomsResource;
use App\Models\Room;
use Illuminate\Http\Request;

class SpecialRoomCotroller extends Controller
{
    public function special()
    {
        return SpecialRoomsResource::collection(
            Room::where('is_special', 1)->get()
        );
    }
    public function new()
    {
        return SpecialRoomsResource::collection(
            Room::where('is_new', 1)->get()
        );
    }
    public function discount()
    {
        return SpecialRoomsResource::collection(
            Room::has('discount')->get()
        );
    }
}
