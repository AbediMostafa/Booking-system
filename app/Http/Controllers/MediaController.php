<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaStoreRequest;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        return Media::select('id', 'display_name', 'path')->paginate(12);
    }

    public function search(Request $request)
    {
        return Media::select('id', 'display_name', 'path')
            ->where('display_name','like', '%'.$request->get('search').'%')
            ->paginate(12);
    }

    public function filter(Request $request)
    {
        return Media::when($request->get('filter'), function($query) use ($request){
            $query->where('media_of', $request->get('filter'));
        })->paginate(12);
    }

    public function upload(MediaStoreRequest $request)
    {
        $pathStore = date('Y/M/d');
        $path = $request->file('file')->store("app/pubic/$pathStore");
        // $imgExtensions = ['jpeg','png','jpg','gif','svg'];
        // $extension = $request->file('file')->getClientOriginalExtension();
        $fileName=explode('.',$request->file('file')->hashName())[0];
             Media::create([
             'display_name' => $request->file('file')->getClientOriginalName(),
             'store_name' => $fileName,
             'path' => $path,
             'type' => substr($request->file('file')->getMimeType(),0,5),
             'media_of'=>$request->media_of,
             'mediaable_id'=>null,
             'mediaable_type'=>null,
         ]);

        
    }
}
