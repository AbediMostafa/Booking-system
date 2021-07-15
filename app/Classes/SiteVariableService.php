<?php

namespace App\Classes;

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
}
