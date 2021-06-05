<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts= DB::table('posts')
        ->select('title','description','image','user_id')
        ->orderBy('created_at', 'desc')
        ->limit(2)
        ->get();
        dd($posts);
        return $posts;
        
    }
}
