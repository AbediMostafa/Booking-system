<?php

namespace App\Http\Controllers;

use App\Classes\Pagination;
use App\Http\Resources\collections\AdminCollectionResource;
use App\Http\Resources\posts\PostResource;
use App\Http\Resources\SingleMovieResource;
use App\Models\Media;
use App\Models\Movie;
use App\Models\News;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function actionDispatcher()
    {
        return $this->{\request('method')}();
    }

    public function actionIndex()
    {
        return ifIsSuperUser(function () {

            $news = News::when(\request()->has('search'), function ($new) {
                $new->where('title', 'like', '%' . \request('search') . '%');
            })->paginate(Pagination::$dashboardEntity);

            return AdminCollectionResource::collection($news);
        });
    }

    public function actionCreateNews()
    {
        \request()->validate([
            'news.title' => 'required|unique:news,title',
            'news.brief' => 'required',
            'news.description' => 'required',
            'medias.image.id' => 'required|exists:media,id'
        ]);

        if (Auth::user()->isSuperUser()) {

            return tryCatch(function () {

                $news = News::create([
                    'title' => \request('news.title'),
                    'brief' => \request('news.brief'),
                    'description' => \request('news.description'),
                    'news_order' => \request('news.news_order'),
                    'user_id' => Auth::id()
                ]);

                $news->medias()->attach([
                    \request()->input('medias.image.id') => [
                        'place' => 'front'
                    ]
                ]);

                $news->tags()->attach(\request('tagIds'));

                if (\request()->input('medias.video.id')) {
                    $news->medias()->attach([
                        \request()->input('medias.video.id') => [
                            'place' => 'video'
                        ]
                    ]);
                }
            }, 'success', 'error');
        }

        return [
            'status' => false,
            'msg' => 'access error'
        ];
    }

    public function actionGet()
    {
        return ifIsSuperUser(function () {
            $news = News::with(['tags' => function ($tag) {
                $tag->select('id', 'name');

            }])->findOrFail(\request('id'));

            $image = $news->mediaType()->first();
            $video = $news->mediaType('video')->first();
            return [
                'newsName' => $news->title,
                'news' => $news->only('id', 'title', 'brief', 'news_order', 'description', 'use_id'),
                'medias' => [
                    'image' => [
                        'background' => $image ? $image->path : '',
                        'id' => $image ? $image->id : '',
                    ],
                    'video' => [
                        'background' => $video ? $video->path : '',
                        'id' => $video ? $video->id : '',
                    ]
                ],
                'selectedTags' => $news->tags
            ];
        });
    }

    public function actionAttachMedia()
    {

        return ifIsSuperUser(function () {

            $news = News::findOrFail(\request('id'));
            $media = Media::findOrFail(\request('mediaId'));

            return tryCatch(function () use ($news, $media) {
                $type = \request()->input('type') == 'video' ? 'video' : 'front';

                $news->mediaType($type)->sync([
                    $media->id => [
                        'place' => $type
                    ]
                ]);
            }, 'success', 'error');
        });
    }

    public function actionDetachMedia()
    {
        return ifIsSuperUser(function(){
            $type = \request('type') == 'video' ? 'video' : 'front';
            $news = News::findOrFail(\request('id'));

            return tryCatch(function () use ($news, $type) {
                $news->mediaType($type)->detach();
            }, 'success', 'error');
        });
    }

    public function actionUpdate()
    {

        return ifIsSuperUser(function(){
            $news = News::findOrFail(\request('id'));

            return tryCatch(function () use ($news) {
                $news->tags()->sync(request('tagIds'));

                $news->update([
                    'title' => \request('title'),
                    'brief' => \request('brief'),
                    'news_order' => \request('news_order'),
                    'description' => \request('description'),
                ]);
            }, 'success', 'error');
        });
    }

    public function actionDelete()
    {
        return ifIsSuperUser(function(){

            \request()->validate([
                'news' => 'required|array',
                'news.*' => 'exists:news,id',
            ]);

            return tryCatch(function () {
                News::destroy(\request('news'));
            }, 'success', 'error');
        });
    }

    public function siteIndex()
    {
        $news = News::orderBy('news_order')->paginate(Pagination::$siteMovie);

        return PostResource::collection($news);
    }

    public function siteGet()
    {
        $news = News::findOrFail(\request('id'));

        return new SingleMovieResource($news);
    }
}
