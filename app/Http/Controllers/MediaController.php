<?php

namespace App\Http\Controllers;

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

    public function upload(Request $request)
    {

        return $request->file('file')->getClientOriginalName();
        $month = date('m');
        $path = $request->file('file')->store("public/uploads/$month");
        return $path;

        return [
            'file'=> $request->file('file'),
            'type'=>$request->get('media_of')
        ];
        
        ;
        // dump($request->get('type'));

    }
}
