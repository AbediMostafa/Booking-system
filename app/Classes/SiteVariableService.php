<?php

namespace App\Classes;

use App\Models\SpecificMedia;

class SiteVariableService
{
    public function __construct($allVars)
    {
        $this->all = $allVars;
    }

    public function item($whereClause)
    {
        return $this->all->where('variable', $whereClause)->first()->value;
    }

    public function itemMedia($whereClause)
    {

        $itemMedia = $this->all
            ->where('variable', $whereClause)
            ->first()
            ->medias()
            ->first();

        return $itemMedia ? $itemMedia->path : '';
    }

    public function carouselItems()
    {
        $medias = [];

        $specificMedias = SpecificMedia::where('name', 'hero_slider')
            ->whereHas('room', function ($room) {
                $room->whereDisabled(0);
            })->get();

        foreach ($specificMedias as $specificMedia) {
            $media = $specificMedia->medias()->first();
            $medias[] = [
                'media' => $media ? $media->path : '',
                'roomId' => $specificMedia->room ? $specificMedia->room->id : ''
            ];
        }

        return $medias;
    }
}
