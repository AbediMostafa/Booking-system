<?php

namespace App\Http\Controllers;

use App\Http\Resources\MultimediaResource;
use App\Models\Movie;
use App\Models\Multimedia;
use App\Models\News;
use App\Models\Post;
use Illuminate\Http\Request;

class MultimediaController extends Controller
{
    public function actionDispatcher()
    {
        return $this->{\request('method')}();
    }

    public function actionIndex()
    {
        return MultimediaResource::collection(Multimedia::with('multimediaable')->get());
    }

    public function actionGetMultimediaAndDependencies()
    {
        return ifIsSuperUser(function () {
            return [
                'multimedias' => Multimedia::select('multimediaable_id', 'multimediaable_type')
                    ->with(['multimediaable'=>function($multimediaable){
                        $multimediaable->select('id', 'title');
                    }])
                    ->get(),

                'dependencies' => [
                    'movie' => Movie::select('id', 'title')->get(),
                    'news' => News::select('id', 'title')->get(),
                    'post' => Post::select('id', 'title')->get(),
                ]
            ];
        });
    }

    public function actionStore()
    {
        return ifIsSuperUser(function(){
            return tryCatch(function(){
             Multimedia::truncate();
             Multimedia::insert(\request('multimedias'));

            },'بروزرسانی با موفقیت انجام شد.','خطا در انجام بروزرسانی');
        });
    }
}
