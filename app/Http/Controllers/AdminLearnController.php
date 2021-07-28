<?php

namespace App\Http\Controllers;

use App\Http\Resources\collections\AdminCollectionResource;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminLearnController extends Controller
{
    public function index()
    {
        return AdminCollectionResource::collection(Post::paginate(10));
    }

    public function search(Request $request)
    {
        return AdminCollectionResource::collection(
            Post::where('title', 'like', '%' . $request->get('search') . '%')->paginate(10)
        );
    }

    public function delete(Request $request)
    {
        $request->validate([
            'posts' => 'required|array',
            'posts.*' => 'exists:posts,id',
        ]);

        Post::whereIn('id', $request->input('posts'))->get()->each(function ($post) {
            $post->delete();
        });

        try {

            return  [
                'status' => true,
                'msg' => 'آموزش ها با موفقیت حذف شدند.'
            ];
        } catch (\Throwable $th) {

            return [
                'status' => false,
                'msg' => 'مشکل در حذف آموزش ها'
            ];
        }
    }

    public function update(Post $post)
    {

        $media = $post->mediaType()->first();
        return [
            'learnName' => $post->title,
            'learn' => $post->only('id', 'title', 'brief', 'description','use_id', 'starred'),
            'media' => [
                'background' => $media ? $media->path : '',
                'id' => $media ? $media->id : '',
            ]
        ];
    }

    public function detachMedia(Post $post)
    {
        $post->medias()->detach();

        return [
            'status' => true,
            'msg' => 'حذف مدیا با موفقیت انجام شد.'
        ];
    }

    public function attachMedia(Post $post, Media $media)
    {
        $post->medias()->sync($media);

        return [
            'status' => true,
            'msg' => 'مدیا با موفقیت اضافه شد'
        ];
    }

    public function change(Request $request, Post $post)
    {
        if(!$post->starred && $request->input('starred')){
            $starredLearnsCount = Post::where('starred', 1)->count();

            if($starredLearnsCount>=2){
                return [
                    'status'=>false,
                    'msg'=>'تعداد آموزش های ستاره دار بیش از حد مجاز است.'
                ];
            }
        }

        $post->update([
            'title' => $request->input('title'),
            'brief' => $request->input('brief'),
            'description' => $request->input('description'),
            'starred' => $request->input('starred'),
        ]);

        return [
            'status' => true,
            'msg' => 'بروزرسانی با موفقیت انجام شد.'
        ];
        try {
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'msg' => 'مشکل در بروزرسانی '
            ];
        }
    }

    public function store(Request $request)
    {

        if($request->input('learn.starred')){
            $starredLearnsCount = Post::where('starred', 1)->count();

            if($starredLearnsCount>=2){
                return [
                    'status'=>false,
                    'msg'=>'تعداد آموزش های ستاره دار بیش از حد مجاز است.'
                ];
            }
        }

        $request->validate([
            'learn.title' => 'required',
            'learn.brief' => 'required',
            'learn.description' => 'required',
            'media.id' => 'required|exists:media,id'
        ]);

        $genre = Post::create([
            'title' => $request->input('learn.title'),
            'brief' => $request->input('learn.brief'),
            'description' => $request->input('learn.description'),
            'starred' => $request->input('learn.starred'),
            'user_id'=>User::first()->id
        ]);

        $genre->medias()->attach($request->input('media.id'));

        return [
            'status' => true,
            'msg' => 'آموزش با موفقیت ایجاد شد'
        ];
    }
}
