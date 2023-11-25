<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        return Media::select('id', 'display_name as name', 'path', 'type')->paginate(12);
    }

    public function search(Request $request)
    {
        return Media::select('id', 'display_name as name', 'path', 'type')
            ->where('display_name', 'like', '%' . $request->get('search') . '%')
            ->paginate(12);
    }

    public function filter(Request $request)
    {

        return Media::select('id', 'display_name as name', 'path', 'type',)->when($request->get('filter'), function ($query) use ($request) {
            $query->whereHas('mediaables', function ($mediaQuery) use ($request) {
                $mediaQuery->where('mediaable_type', $request->input('filter'));
            });
        })->paginate(12);
    }

    public function upload(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,bmp,tiff,mp4,mov,ogg,qt,flv,3gp,avi,wmv,gif',
        ]);

        $imageExtensions = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];
        $file = $request->file('file');
        $date = date('y/m');
        $extension = $file->getClientOriginalExtension();

        $fileType = in_array($extension, $imageExtensions) ? 'image' : 'video';

        if ($path = $file->store("public/uploads/$date")) {
            $publicPath = str_replace('public', '/storage', $path);

            Media::create([
                'display_name' => $file->getClientOriginalName(),
                'store_name' => $file->hashName(),
                'path' => $publicPath,
                'type' => $fileType,
            ]);

            return [
                'status' => true,
                'msg' => 'success'
            ];
        }

        return [
            'status' => false,
            'msg' => 'error'
        ];
    }

    public function delete(Request $request)
    {
        $request->validate([
            'medias' => 'required|array',
            'medias.*' => 'exists:media,id',
        ]);

        return tryCatch(function () {
            Media::destroy(\request('medias'));
        }, 'success', 'error');
    }

    public function modal(Request $request)
    {
        return Media::when($request->get('itemKey'), function ($media) use ($request) {
            $media->where('display_name', 'like', '%' . $request->get('itemKey') . '%');

        })->select('id', 'display_name as name', 'path', 'type')
            ->where('type', $request->get('type'))->get();
    }
}
