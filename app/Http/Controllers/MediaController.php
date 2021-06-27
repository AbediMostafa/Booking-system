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
}
