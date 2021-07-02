<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        return Media::select('id', 'display_name as name', 'path', 'type', 'media_of')->paginate(12);
    }

    public function search(Request $request)
    {
        return Media::select('id', 'display_name as name', 'path', 'type', 'media_of')
            ->where('display_name', 'like', '%' . $request->get('search') . '%')
            ->paginate(12);
    }

    public function filter(Request $request)
    {
        return Media::select('id', 'display_name as name', 'path', 'type', 'media_of')->when($request->get('filter'), function ($query) use ($request) {
            $query->where('media_of', $request->get('filter'));
        })->paginate(12);
    }

    public function upload(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,bmp,tiff,mp4,mov,ogg,qt,flv,3gp,avi,wmv',
        ]);

        $imageExtensions = ['jpg', 'jpeg', 'png', 'bmp'];
        $file = $request->file('file');
        $month = date('m');
        $extension = $file->getClientOriginalExtension();

        $fileType = in_array($extension, $imageExtensions) ? 'image' : 'video';
        
        if ($path = $file->store("public/uploads/$month")) {
            $publicPath = str_replace('public', '/storage', $path);
            
            Media::create([
                'display_name' => $file->getClientOriginalName(),
                'store_name' => $file->hashName(),
                'path' => $publicPath,
                'media_of' => 'other',
                'type' => $fileType,
                'place' => 'other',
                'mediaable_id' => null,
                'mediaable_type' => null
            ]);

            return [
                'status' => true,
                'msg' => 'فایل با موفقیت بارگزاری شد.'
            ];
        }

        return [
            'status' => false,
            'msg' => 'مشکل در بارگزاری فایل'
        ];
    }

    public function delete(Request $request)
    {
        $request->validate([
            'medias' => 'required|array',
            'medias.*' => 'exists:media,id',
        ]);

        try {

            Media::whereIn('id', $request->get('medias'))->get()->each(function ($media) {
                $media->delete();
            });

            return [
                'status' => true,
                'msg' => 'مدیاها با موفقیت حذف شدند.'
            ];
        } catch (\Throwable $th) {
            [
                'status' => false,
                'msg' => 'مشکل در حذف مدیاها'
            ];
        }
    }

    public function modal(Request $request)
    {
        return Media::select('id', 'display_name as name', 'path', 'media_of', 'type')
            ->where([
                ['media_of', 'other'],
                ['type', $request->get('type')],
            ])->get();
    }
}
