<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSiteVarsRequest;
use App\Http\Resources\site_variables\SiteVariableCollection;
use App\Http\Resources\site_variables\SiteVariableFirstPageResource;
use App\Http\Resources\site_variables\SiteVariableIndexPageResource;
use App\Http\Resources\site_variables\SiteVariableResourceForIndexCollection;
use App\Http\Resources\site_variables\SpecialRoomResource;
use App\Models\Media;
use App\Models\SiteVariables;
use phpDocumentor\Reflection\PseudoTypes\False_;

class SiteVariablesController extends Controller
{

    public function index()
    {
        return new SiteVariableResourceForIndexCollection(SiteVariables::all());
    }


    public function getFirstPageVars()
    {
        return new SiteVariableFirstPageResource(SiteVariables::all());
    }

    public function getSpecialRoomsVars()
    {
        return new SpecialRoomResource(SiteVariables::all());
    }

    public function getVar($title, $text)
    {
        $cityTitle = SiteVariables::whereVariable($title)->first();
        return [
            'title' => $cityTitle->value,
            'text' => SiteVariables::whereVariable($text)->first()->value,
            'media' => $cityTitle->medias()->first() ? $cityTitle->medias()->first()->path : ''
        ];
    }

    public function getCitiesPageVars()
    {
        return $this->getVar('city_page_title', 'city_page_text');
    }

    public function getCollectionsPageVars()
    {
        return $this->getVar('collection_page_title', 'collection_page_text');
    }

    public function getGenresPageVars()
    {
        return $this->getVar('genre_page_title', 'genre_page_text');
    }

    public function getLearningsPageVars()
    {
        return $this->getVar('learning_page_title', 'learning_page_text');
    }

    public function getMoviesPageVars()
    {
        return $this->getVar('movie_page_title', 'movie_page_text');
    }

    public function getNewsPageVars()
    {
        return $this->getVar('news_page_title', 'news_page_text');
    }

    public function rateTitles()
    {
        return [
            'scariness' => $this->getValue('rate_scariness'),
            'room_decoration' => $this->getValue('rate_room_decoration'),
            'hobbiness' => $this->getValue('rate_hobbiness'),
            'creativeness' => $this->getValue('rate_creativeness'),
            'mysteriness' => $this->getValue('rate_mysteriness'),
        ];
    }

    public function getValue($title)
    {
        return SiteVariables::whereVariable($title)->first()->value;
    }

    public function attachMedia(SiteVariables $siteVariables, Media $media)
    {

        try {
            $siteVariables->medias()->sync($media);

            return [
                'status' => true,
                'msg' => 'success'
            ];

        } catch (\Throwable $th) {

            return [
                'status' => false,
                'msg' => 'error'
            ];
        }
    }

    public function detachMedia(SiteVariables $siteVariables)
    {
        try {
            if ($siteVariables->medias()->exists()) {
                $siteVariables->medias()->detach();
            }

            return [
                'status' => true,
                'msg' => 'success'
            ];

        } catch (\Throwable $th) {

            return [
                'status' => false,
                'msg' => 'error'
            ];
        }
    }

    public function update(UpdateSiteVarsRequest $request)
    {
        $siteVars = SiteVariables::all();

        return tryCatch(function () use ($request, $siteVars) {
            foreach ($request->all() as $key => $singleRequest) {
                $siteVars->where('variable', $key)->first()->update([
                    'value' => $singleRequest
                ]);
            }
        }, 'success', 'error');
    }
}
