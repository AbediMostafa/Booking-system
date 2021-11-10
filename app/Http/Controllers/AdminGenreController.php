<?php

namespace App\Http\Controllers;

use App\Http\Resources\collections\AdminCollectionResource;
use App\Models\Genre;
use App\Models\Media;
use Illuminate\Http\Request;

class AdminGenreController extends Controller
{
    public function index()
    {
        return AdminCollectionResource::collection(Genre::paginate(10));
    }

    public function search(Request $request)
    {
        return AdminCollectionResource::collection(
            Genre::where('title', 'like', '%' . $request->get('search') . '%')->paginate(10)
        );
    }

    public function delete(Request $request)
    {
        $request->validate([
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ]);

        return tryCatch(function (){
            Genre::destroy(\request('genres'));
        },'ژانرها با موفقیت حذف شدند.','مشکل در حذف ژانرها');
    }

    public function update(Genre $genre)
    {

        $media = $genre->mediaType()->first();
        return [
            'genreName' => $genre->title,
            'genre' => $genre->only('id', 'title'),
            'media' => [
                'background' => $media ? $media->path : '',
                'id' => $media ? $media->id : '',
            ]
        ];
    }

    public function detachMedia(Genre $genre)
    {
        $genre->medias()->detach();

        return [
            'status' => true,
            'msg' => 'حذف مدیا با موفقیت انجام شد.'
        ];
    }

    public function attachMedia(Genre $genre, Media $media)
    {
        $genre->medias()->sync($media);

        return [
            'status' => true,
            'msg' => 'مدیا با موفقیت اضافه شد'
        ];
    }

    public function change(Request $request, Genre $genre)
    {
        $genre->update([
            'title' => $request->input('title')
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
        $request->validate([
            'genre.name' => 'required',
            'media.id' => 'required|exists:media,id'
        ]);

        $genre = Genre::create([
            'title' => $request->input('genre.name')
        ]);

        $genre->medias()->attach($request->input('media.id'));

        return [
            'status' => true,
            'msg' => 'ژانر با موفقیت ایجاد شد'
        ];
    }
}
