<?php

namespace App\Http\Controllers;

use App\Classes\Pagination;
use App\Http\Middleware\AuthorizeSuperUser;
use App\Http\Requests\MovieRequest;
use App\Http\Resources\collections\AdminCollectionResource;
use App\Http\Resources\posts\PostResource;
use App\Http\Resources\SingleMovieResource;
use App\Models\Media;
use App\Models\Movie;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{

    public function actionDispatcher()
    {
        return $this->{\request()->input('method')}();
    }

    public function actionIndex()
    {
        return ifIsSuperUser(function () {
            $movies = Movie::when(\request()->has('search'), function ($movie) {
                $movie->where('title', 'like', '%' . \request('search') . '%');
            })->paginate(Pagination::$dashboardEntity);

            return AdminCollectionResource::collection($movies);
        });
    }

    public function actionCreateMovie()
    {
        \request()->validate([
            'movie.title' => 'required|unique:movies,title',
            'movie.brief' => 'required',
            'movie.description' => 'required',
            'medias.image.id' => 'required|exists:media,id'
        ]);

        if (Auth::user()->isSuperUser()) {

            return tryCatch(function () {

                $movie = Movie::create([
                    'title' => \request('movie.title'),
                    'brief' => \request('movie.brief'),
                    'description' => \request('movie.description'),
                    'movie_order' => \request('movie.movie_order'),
                    'user_id' => Auth::id()
                ]);

                $movie->tags()->attach(\request('tagIds'));

                $movie->medias()->attach([
                    \request()->input('medias.image.id') => [
                        'place' => 'front'
                    ]
                ]);

                if (\request()->input('medias.video.id')) {
                    $movie->medias()->attach([
                        \request()->input('medias.video.id') => [
                            'place' => 'video'
                        ]
                    ]);
                }
            }, 'success', 'error');
        }

        return [
            'status' => false,
            'msg' => 'access errro'
        ];
    }

    public function actionGet()
    {
        return ifIsSuperUser(function () {
            $movie = Movie::with(['tags' => function ($tag) {
                $tag->select('id', 'name');

            }])->findOrFail(\request('id'));

            $image = $movie->mediaType()->first();
            $video = $movie->mediaType('video')->first();
            return [
                'movieName' => $movie->title,
                'movie' => $movie->only('id', 'title', 'brief', 'movie_order', 'description', 'use_id'),
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
                'selectedTags' => $movie->tags
            ];
        });
    }

    public function actionAttachMedia()
    {
        $movie = Movie::findOrFail(\request('id'));
        $media = Media::findOrFail(\request('mediaId'));

        return tryCatch(function () use ($movie, $media) {
            $type = \request()->input('type') == 'video' ? 'video' : 'front';

            $movie->mediaType($type)->sync([
                $media->id => [
                    'place' => $type
                ]
            ]);
        }, 'success', 'error');
    }

    public function actionDetachMedia()
    {
        $type = \request('type') == 'video' ? 'video' : 'front';
        $movie = Movie::findOrFail(\request('id'));

        tryCatch(function () use ($movie, $type) {
            $movie->mediaType($type)->detach();
        }, 'success', 'error');
    }

    public function actionUpdate()
    {
        $movie = Movie::findOrFail(\request('id'));

        return tryCatch(function () use ($movie) {

            $movie->tags()->sync(\request('tagIds'));

            $movie->update([
                'title' => \request('title'),
                'brief' => \request('brief'),
                'movie_order' => \request('movie_order'),
                'description' => \request('description'),
            ]);
        }, 'success', 'error');
    }

    public function actionDelete()
    {
        \request()->validate([
            'movies' => 'required|array',
            'movies.*' => 'exists:movies,id',
        ]);

        return tryCatch(function () {
            Movie::destroy(\request('movies'));
        }, 'success', 'error');
    }

    public function siteIndex()
    {
        $movies = Movie::orderBy('movie_order')->paginate(Pagination::$siteMovie);

        return PostResource::collection($movies);
    }

    public function siteGet()
    {
        $movie = Movie::findOrFail(\request('id'));

        return new SingleMovieResource($movie);
    }
}
