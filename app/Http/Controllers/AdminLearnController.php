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

        return tryCatch(function () use ($request) {
            Post::destroy(\request('posts'));
        }, '');
    }

    public function update(Post $post)
    {

        $image = $post->mediaType()->first();
        $video = $post->mediaType('video')->first();
        return [
            'learnName' => $post->title,
            'learn' => $post->only('id', 'title', 'brief', 'description', 'use_id', 'starred'),
            'selectedTags'=>$post->tags()->select('id', 'name')->get(),
            'medias' => [
                'image' => [
                    'background' => $image ? $image->path : '',
                    'id' => $image ? $image->id : '',
                ],
                'video' => [
                    'background' => $video ? $video->path : '',
                    'id' => $video ? $video->id : '',
                ]
            ]
        ];
    }

    public function detachMedia(Request $request, Post $post)
    {
        $type = $request->input('type') == 'video' ? 'video' : 'front';

        $post->mediaType($type)->detach();

        return [
            'status' => true,
            'msg' => 'success'
        ];
    }

    public function attachMedia(Request $request, Post $post, Media $media)
    {
        $type = $request->input('type') == 'video' ? 'video' : 'front';

        $post->mediaType($type)->sync([
            $media->id => [
                'place' => $type
            ]
        ]);

        return [
            'status' => true,
            'msg' => 'success'
        ];
    }

    public function change(Request $request, Post $post)
    {
        if (!$post->starred && $request->input('starred')) {
            $starredLearnsCount = Post::where('starred', 1)->count();

            if ($starredLearnsCount >= 2) {
                return [
                    'status' => false,
                    'msg' => 'too much changes'
                ];
            }
        }

        return tryCatch(function () use ($post, $request) {
            $post->tags()->sync($request->input('tagIds'));
            $post->update([
                'title' => $request->input('title'),
                'brief' => $request->input('brief'),
                'description' => $request->input('description'),
                'starred' => $request->input('starred'),
            ]);
        }, 'success', 'error');
    }

    public function store(Request $request)
    {

        if ($request->input('learn.starred')) {
            $starredLearnsCount = Post::where('starred', 1)->count();

            if ($starredLearnsCount >= 2) {
                return [
                    'status' => false,
                    'msg' => 'stared learnings exceeded'
                ];
            }
        }

        $request->validate([
            'learn.title' => 'required',
            'learn.brief' => 'required',
            'learn.description' => 'required',
            'medias.image.id' => 'required|exists:media,id',
            'tagIds'=>'array',
            'tagIds.*'=>'exists:tags,id'
        ]);

        return tryCatch(function () use($request){
            $post = Post::create([
                'title' => $request->input('learn.title'),
                'brief' => $request->input('learn.brief'),
                'description' => $request->input('learn.description'),
                'starred' => $request->input('learn.starred'),
                'user_id' => User::first()->id
            ]);

            $post->medias()->attach([
                $request->input('medias.image.id') => [
                    'place' => 'front'
                ]
            ]);

            $post->tags()->attach($request->input('tagIds'));

            if ($request->input('medias.video.id')) {
                $post->medias()->attach([
                    $request->input('medias.video.id') => [
                        'place' => 'video'
                    ]
                ]);
            }

        },'success','error');
    }
}
