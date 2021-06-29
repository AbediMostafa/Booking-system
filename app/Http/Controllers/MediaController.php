<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaStoreRequest;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        return Media::select('id', 'display_name', 'path')->paginate(12);
    }

    public function search(Request $request)
    {
        return Media::select('id', 'display_name', 'path')
            ->where('display_name', 'like', '%' . $request->get('search') . '%')
            ->paginate(12);
    }

    public function filter(Request $request)
    {
        return Media::when($request->get('filter'), function ($query) use ($request) {
            $query->where('media_of', $request->get('filter'));
        })->paginate(12);
    }

    public function upload(MediaStoreRequest $request)
    {
        $pathStore = date('y/m');
        $path = $request->file('file')->store("pubic/uploads/$pathStore");

        $publicPath = str_replace('public', 'storage', $path);
        $fileName = $request->file('file')->hashName();
        Media::create([
            'display_name' => $request->file('file')->getClientOriginalName(),
            'store_name' => $fileName,
            'path' => $publicPath,
            'type' => substr($request->file('file')->getMimeType(), 0, 5),
            'media_of' => $request->media_of,
            'mediaable_id' => null,
            'mediaable_type' => null,
        ]);
    }

    public function delete(Request $request)
    {
        //medias
        //array, 

        $request->validate([
            'medias' => 'array|required',
            'medias.*' => 'exists:medias,id'
        ]);

        try {
            Media::whereIn('id', $request->get('medias'))->get()->each(function ($media) {
                $media->delete();
            });

            return[
                'status'=>true,
                'msg'=>'مدیاها با موفقیت حذف شدند'
            ];

        } catch (\Throwable $th) {
            return [
                'status'=>false,
                'msg'=>'مشکل در حذف مدیاها'
            ];
        }

        
    }
}
