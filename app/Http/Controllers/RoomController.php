<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Collection;
use App\Models\Genre;
use App\Models\Room;
use Illuminate\Http\Request;
use stdClass;

class RoomController extends Controller
{
    public function complicatedSearch(request $request)
    {
        $request = new stdClass;
        $request->room='';
        $request->collection = '';
        $request->genre = '';
        $request->city = 'کردستان';
        $request->persons['min']=9;
        $request->persons['max']=15;
        $request->persons = '';
        $cities = $request->city ? '' : $this->getCity($request);
        $genres = $request->genre ? '' : $this->getGenre($request);
        $collections = $request->collection ? '' : $this->getCollection($request);
        $rooms = $request->room ? '' : $this->getRoom($request);

        dd($rooms);
    }
    public function getCity($request)
    {
        $cities = City::when($request->collection, function ($cityQuery) use ($request) {
            $cityQuery->whereHas('rooms', function ($roomQuery) use ($request) {
                $roomQuery->whereHas('collection', function ($qureyCollection) use ($request) {
                    $qureyCollection->where('title', $request->collection);
                });
            });
        })->when($request->genre,function($cityQuery)use ($request){
            $cityQuery->whereHas('rooms',function($roomQuery)use ($request){
                $roomQuery->whereHas('genres',function($genresQuery)use ($request){
                    $genresQuery->where('title',$request->genre);
                });
            });
        }
        
        )->when($request->persons,function($cityQuery)use ($request){
            $cityQuery->whereHas('rooms',function($roomQuery)use ($request){
               $roomQuery->where('max_person',$request->persons['max'])->where('min_person',$request->persons['min']);
            });
        }
        )->get();
        return $cities;
    }
    public function getGenre($request)
    {
        $genres=Genre::when($request->collection,function($genresQuery)use ($request){
            $genresQuery->whereHas('rooms',function($roomQuery)use ($request){
                $roomQuery->whereHas('collection',function($qureyCollection)use ($request){
                    $qureyCollection->where('title',$request->collection);
                });
            });
        }
        )
        ->when($request->city,function($genreQuery)use ($request){
            $genreQuery->whereHas('rooms',function($roomQuery)use ($request){
                $roomQuery->whereHas('city',function($cityQuery)use ($request){
                    $cityQuery->where('name',$request->city);
                });
            });
        })
        ->when($request->persons,function($genreQuery)use ($request){
            $genreQuery->whereHas('rooms',function($roomQuery)use ($request){
                $roomQuery->where('min_person',$request->persons['min'])->where('max_person',$request->persons['max']);
            });
        })
        ->get();
        return $genres;
    }
    public function getCollection($request)
    {
        $collections=Collection::when($request->city,function($cityQuery)use ($request){
            $cityQuery->whereHas('rooms',function($collectionQuery)use ($request){
                $collectionQuery->whereHas('city',function($roomQuery)use ($request){
                    $roomQuery->where('name',$request->city);
                });
            });
        })
        ->when($request->genre,function($collectionQuery)use ($request){
            $collectionQuery->whereHas('rooms',function($roomQuery)use ($request){
                $roomQuery->whereHas('genres',function($genreQuery)use ($request){
                $genreQuery->where('title',$request->genre);
                });
            });
        })
        ->when($request->persons,function($collectionQuery)use ($request){
            $collectionQuery->whereHas('rooms',function($roomQuery)use ($request){
            $roomQuery->where('min_person',$request->persons['min'])->where('max_person',$request->persons['max']);
            });
        })
        ->get();
        return $collections;
    }
    public function getRoom($request)
    {
        $rooms=Room::when($request->collection,function($roomQuery)use ($request){
            $roomQuery->where('collection',function($collectionQuery)use ($request){
                $collectionQuery->where('title',$request->collection);
            });
        })
        ->when($request->city,function($roomQuery)use ($request){
            $roomQuery->whereHas('city',function($cityQuery)use ($request){
                $cityQuery->where('name',$request->city);
            });
        })
        ->when($request->genre,function($roomQuery)use ($request){
            $roomQuery->whereHas('genres',function($genresQuery)use ($request){
                $genresQuery->where('title',$request->genre);
            });
        })
        ->when($request->persons,function($roomQuery)use ($request){
            $roomQuery->where('min_person',$request->persons['min'])->where('max_person',$request->persons['max']);
        })
        ->get();
    }

}
