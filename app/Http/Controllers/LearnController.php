<?php

namespace App\Http\Controllers;

use App\Http\Resources\posts\PostWithSpecialRoomResource;
use App\Models\Post;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    public function show(Post $post)
    {
        return new PostWithSpecialRoomResource($post);
    }
}
