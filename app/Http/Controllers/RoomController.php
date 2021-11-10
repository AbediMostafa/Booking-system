<?php

namespace App\Http\Controllers;

use App\Classes\Pagination;
use App\Http\Resources\cities\CitiesFilterResource;
use App\Http\Resources\collections\CollectionFilterResource;
use App\Http\Resources\comments\RoomCommentsResource;
use App\Http\Resources\genres\GenresFilterResource;
use App\Http\Resources\rooms\CollectionRoomResource;
use App\Http\Resources\rooms\ComplicatedRoomResource;
use App\Http\Resources\Rooms\RoomDescriptionResource;
use App\Models\City;
use App\Models\Collection;
use App\Models\Comment;
use App\Models\Genre;
use App\Models\Room;
use App\Models\SiteVariables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function complicatedSearch(request $request)
    {
        return [
            'cities' => CitiesFilterResource::collection($this->getCity($request)),
            'genres' => GenresFilterResource::collection($this->getGenre($request)),
            'collections' => CollectionFilterResource::collection($this->getCollection($request)),
            'persons' => $this->getPersonRange($request),
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

    public function complicatedRooms(Request $request)
    {
        \DB::statement("SET SQL_MODE=''");
        $rooms = Room::leftJoin(
            'rates',
            'rooms.id', '=', 'rates.room_id')
            ->selectRaw(
                'AVG((rates.scariness+ rates.room_decoration + rates.hobbiness+rates.creativeness+rates.mysteriness)/5) as averages,
            rooms.*',

            )->with('collection')
            ->when($request->collections, function ($roomQuery) use ($request) {
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
            ->when($request->searchKey, function ($roomQuery) use ($request) {
                $roomQuery->where('name', 'like', '%' . $request->searchKey . '%');
            })
            ->whereDisabled(0)
            ->withCount('comments')
            ->withCount('rates')
            ->groupBy('rooms.id')
            ->orderBy('room_order')
            ->orderBy('averages','DESC')
            ->orderBy('page_views','DESC')
            ->orderBy('comments_count','DESC')
            ->paginate(Pagination::$paginationCount);

        return ComplicatedRoomResource::collection($rooms);
    }

    public function show($room)
    {
        $room = Room::whereDisabled(0)->findOrFail($room);
        return new RoomDescriptionResource($room);
    }

    public function comments(Room $room)
    {
        $comments = $room->comments()
            ->with(['childs' => function ($child) {
                $child->whereSituation('promoted');
            }])
            ->whereSituation('promoted')
            ->whereParentId(null)
            ->paginate(10);

        return RoomCommentsResource::collection($comments);
    }

    public function insertComment(Room $room)
    {
        return view('insert_comment', [
            'type' => 'insert',
            'roomName' => $room->name,
            'roomId' => $room->id,
            'comment' => '',
            'commenting_rules' => SiteVariables::where('variable', 'commenting_rules')->first()->value
        ]);
    }

    public function editComment(Comment $comment)
    {
        $comment->load(['commentable.rates' => function ($rate) {
            $rate->where('user_id', Auth::id());
        }]);

        $rate = $comment->commentable->rates[0];

        return view('insert_comment', [
            'type' => 'edit',
            'comment' => [
                'scoresTitles' => [
                    'scariness' => ['title' => '', 'selectedKey' => $rate->scariness],
                    'room_decoration' => ['title' => '', 'selectedKey' => $rate->room_decoration],
                    'hobbiness' => ['title' => '', 'selectedKey' => $rate->hobbiness],
                    'creativeness' => ['title' => '', 'selectedKey' => $rate->creativeness],
                    'mysteriness' => ['title' => '', 'selectedKey' => $rate->mysteriness],
                ],

                'roomInfo' => [
                    'name' => $comment->commentable->name,
                    'id' => $comment->commentable->id
                ],
                'selectedStatus' => $comment->status,
                'comment' => $comment->body
            ],
            'commenting_rules' => SiteVariables::where('variable', 'commenting_rules')->first()->value
        ]);
    }

    public function landingSearch(Request $request)
    {
        return CollectionRoomResource::collection(
            Room::where('name', 'like', '%' . $request->input('query') . '%')
                ->whereDisabled(0)
                ->get()
        );
    }
}
