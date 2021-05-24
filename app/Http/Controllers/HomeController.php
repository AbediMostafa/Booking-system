<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post=City::find(1)->rooms;
        return $post;
        // dd($post->comments );
        

        // $post = Post::find(1);   
 
        // $comment = new Comment();
        // $comment->body = "Hi nicesnippets.com";
        // $comment->up_rate='12';
        // $comment->down_rate='10';
        // $comment->user_id=1;
        // $comment->status='پیشنهاد میکنم';
        // $post->comments()->save($comment);

        // $room = Room::find(1);   
        // $comment = new Comment();
        // $comment->body = "bad bad";
        // $comment->up_rate='12';
        // $comment->down_rate='10';
        // $comment->user_id=1;
        // $comment->status='پیشنهاد نمی کنم';
        // $room->comments()->save($comment);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
