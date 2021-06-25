<?php

namespace App\Http\Controllers;

use App\Http\Resources\posts\PostResource;
use App\Http\Resources\posts\PostWithSpecialRoomResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Post::paginate(6));
    }
    
    public function show(Post $post)
    {
        return new PostWithSpecialRoomResource($post);
    }
    
    public function starred()
    {
        return PostResource::collection(Post::where('starred', 1)->get());
    }
}
