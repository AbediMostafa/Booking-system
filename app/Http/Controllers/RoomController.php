<?php

namespace App\Http\Controllers;

use App\Http\Resources\collections\RoomCollectionResource;
use App\Http\Resources\rooms\RoomForRoomPageResource;
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
        return [
            'cities' => $this->getCity($request),
            'genres' => $this->getGenre($request),
            'collections' => $this->getCollection($request),
            'persons' => $this->getPersonRange($request),
            'rooms' => $this->getRoom($request)
        ];
    }

    public function getPersonRange($request)
    {
        $rooms = Room::when($request->collections, function ($roomQuery) use ($request) {
            $roomQuery->whereHas('collection', function ($collectionQuery) use ($request) {
                $collectionQuery->where('title', $request->collections);
            });
        })->when($request->genres, function ($roomQuery) use ($request) {
            $roomQuery->whereHas('genres', function ($genreQuery) use ($request) {
                $genreQuery->where('title', $request->genres);
            });
        })->when($request->cities, function ($roomQuery) use ($request) {
            $roomQuery->whereHas('city', function ($cityQuery) use ($request) {
                $cityQuery->where('name', $request->cities);
            });
        })->get();

        return $this->getRange($rooms);
    }

    public function getRange($rooms)
    {
        return range($rooms->min('min_person'), $rooms->max('max_person'));
    }
    public function getCity($request)
    {
        $cities = City::when($request->collections, function ($cityQuery) use ($request) {
            $cityQuery->whereHas('rooms', function ($roomQuery) use ($request) {
                $roomQuery->whereHas('collection', function ($qureyCollection) use ($request) {
                    $qureyCollection->where('title', $request->collections);
                });
            });
        })->when(
            $request->genres,
            function ($cityQuery) use ($request) {
                $cityQuery->whereHas('rooms', function ($roomQuery) use ($request) {
                    $roomQuery->whereHas('genres', function ($genresQuery) use ($request) {
                        $genresQuery->where('title', $request->genres);
                    });
                });
            }

        )->when(
            $request->personCount,
            function ($cityQuery) use ($request) {
                $cityQuery->whereHas('rooms', function ($roomQuery) use ($request) {
                    $roomQuery->where([['min_person', '<=', $request->personCount], ['max_person', '>=', $request->personCount]]);
                });
            }
        )->get();
        return $cities;
    }
    public function getGenre($request)
    {
        $genres = Genre::when(
            $request->collections,
            function ($genresQuery) use ($request) {
                $genresQuery->whereHas('rooms', function ($roomQuery) use ($request) {
                    $roomQuery->whereHas('collection', function ($qureyCollection) use ($request) {
                        $qureyCollection->where('title', $request->collections);
                    });
                });
            }
        )
            ->when($request->cities, function ($genreQuery) use ($request) {
                $genreQuery->whereHas('rooms', function ($roomQuery) use ($request) {
                    $roomQuery->whereHas('city', function ($cityQuery) use ($request) {
                        $cityQuery->where('name', $request->cities);
                    });
                });
            })
            ->when($request->personCount, function ($genreQuery) use ($request) {
                $genreQuery->whereHas('rooms', function ($roomQuery) use ($request) {
                    $roomQuery->where([['min_person', '<=', $request->personCount], ['max_person', '>=', $request->personCount]]);
                });
            })
            ->get();
        return $genres;
    }
    public function getCollection($request)
    {
        $collections = Collection::when($request->cities, function ($collectionQuery) use ($request) {
            $collectionQuery->whereHas('rooms', function ($roomQuery) use ($request) {
                $roomQuery->whereHas('city', function ($roomQuery) use ($request) {
                    $roomQuery->where('name', $request->cities);
                });
            });
        })
            ->when($request->genres, function ($collectionQuery) use ($request) {
                $collectionQuery->whereHas('rooms', function ($roomQuery) use ($request) {
                    $roomQuery->whereHas('genres', function ($genreQuery) use ($request) {
                        $genreQuery->where('title', $request->genres);
                    });
                });
            })
            ->when($request->personCount, function ($collectionQuery) use ($request) {
                $collectionQuery->whereHas('rooms', function ($roomQuery) use ($request) {
                    $roomQuery->where([['min_person', '<=', $request->personCount], ['max_person', '>=', $request->personCount]]);
                });
            })
            ->get();
        return $collections;
    }
    public function getRoom($request)
    {
        $rooms = Room::with('collection')->when($request->collections, function ($roomQuery) use ($request) {
            $roomQuery->whereHas('collection', function ($collectionQuery) use ($request) {
                $collectionQuery->where('title', $request->collections);
            });
        })
            ->when($request->cities, function ($roomQuery) use ($request) {
                $roomQuery->whereHas('city', function ($cityQuery) use ($request) {
                    $cityQuery->where('name', $request->cities);
                });
            })
            ->when($request->genres, function ($roomQuery) use ($request) {
                $roomQuery->whereHas('genres', function ($genresQuery) use ($request) {
                    $genresQuery->where('title', $request->genres);
                });
            })
            ->when($request->personCount, function ($roomQuery) use ($request) {
                $roomQuery->where([['min_person', '<=', $request->personCount], ['max_person', '>=', $request->personCount]]);
            })
            ->get();

        return $rooms;
    }
}
