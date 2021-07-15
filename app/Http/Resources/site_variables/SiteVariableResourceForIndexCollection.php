<?php

namespace App\Http\Resources\site_variables;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SiteVariableResourceForIndexCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $withMediavars = $this->collection->filter(function ($var) {
            return $var->medias()->first();
        });

        return [
            'postData' => $this->collection->pluck('value', 'variable'),
            'withMediaVarIds' => [
                'first_page_header_title_1' =>$this->getVarId('first_page_header_title_1'),
                'first_page_header_title_2' =>$this->getVarId('first_page_header_title_2'),
                'first_page_header_title_3' =>$this->getVarId('first_page_header_title_3'),
                'city_page_title' =>$this->getVarId('city_page_title'),
                'learning_page_title' =>$this->getVarId('learning_page_title'),
                'collection_page_title' =>$this->getVarId('collection_page_title'),
                'genre_page_title' =>$this->getVarId('genre_page_title'),
            ],
            'withMediaVarImages' => [
                'first_page_header_title_1' =>$this->getVarImg('first_page_header_title_1'),
                'first_page_header_title_2' =>$this->getVarImg('first_page_header_title_2'),
                'first_page_header_title_3' =>$this->getVarImg('first_page_header_title_3'),
                'city_page_title' =>$this->getVarImg('city_page_title'),
                'learning_page_title' =>$this->getVarImg('learning_page_title'),
                'collection_page_title' =>$this->getVarImg('collection_page_title'),
                'genre_page_title' =>$this->getVarImg('genre_page_title'),
            ],
        ];
    }

    public function getVarId($var)
    {
        return $this->collection->where('variable', $var)->first()->id;
    }
    
    public function getVarImg($var)
    {
        
        $varImg = $this->collection
        ->where('variable', $var)
        ->first()
        ->medias()
        ->first();

        return $varImg?$varImg->path:'';
    }
}
