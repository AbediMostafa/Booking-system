<?php

namespace App\Http\Controllers;

use App\Classes\Pagination;
use App\Http\Resources\rooms\SpecialRoomsResource;
use App\Models\Room;

class SpecialRoomCotroller extends Controller
{
    public function special()
    {
        return SpecialRoomsResource::collection(
            Room::where('is_special', 1)->whereDisabled(0)->paginate(Pagination::$paginationCount)
        );
    }
    public function new()
    {
        return SpecialRoomsResource::collection(
            Room::where('is_new', 1)->whereDisabled(0)->paginate(Pagination::$paginationCount)
        );
    }
    public function discount()
    {
        return SpecialRoomsResource::collection(
            Room::has('discount')->whereDisabled(0)->paginate(Pagination::$paginationCount)
        );
    }
}
