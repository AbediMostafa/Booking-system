<?php

namespace App\Http\Controllers;

use App\Classes\Pagination;
use App\Http\Resources\collections\AdminCollectionResource;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagContoller extends Controller
{
    public function actionDispatcher()
    {
        return $this->{\request('method')}();
    }

    public function actionIndex()
    {
        return Tag::when(\request()->has('search'), function ($tag) {
            $tag->where('name', 'like', '%' . \request('search') . '%');
        })->paginate(Pagination::$dashboardEntity);
    }

    public function actionDelete()
    {
        \request()->validate([
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        return tryCatch(function () {
            Tag::destroy(\request('tags'));
        }, 'success', 'error');
    }

    public function actionAdd()
    {
        return tryCatch(function () {
            Tag::create([
                'name' => \request('tag.name')
            ]);

        }, 'success', 'error');
    }

    public function actionUpdate()
    {
        \request()->validate([
            'tag.id' => 'exists:tags,id'
        ]);

        $tag = Tag::findOrFail(\request('tag.id'));

        return tryCatch(function () use ($tag) {
            $tag->name = \request('tag.name');
            $tag->save();
        }, 'success', 'error');
    }
}
