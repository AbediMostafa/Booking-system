<?php

namespace App\Http\Controllers;

use App\Http\Resources\rooms\AdminRoomResource;
use App\Models\City;
use App\Models\Media;
use Illuminate\Http\Request;

class AdminCityController extends Controller
{
    public function index()
    {
        return AdminRoomResource::collection(City::paginate(10));
    }

    public function search(Request $request)
    {
        return AdminRoomResource::collection(
            City::where('name', 'like', '%' . $request->get('search') . '%')->paginate(10)
        );
    }

    public function delete(Request $request)
    {
        $request->validate([
            'cities' => 'required|array',
            'cities.*' => 'exists:cities,id',
        ]);

        return tryCatch(function (){
            City::destroy(\request('cities'));
        },'');
    }

    public function update(City $city)
    {

        $media = $city->mediaType()->first();
        return [
            'cityName' => $city->name,
            'city' => $city->only('id', 'name'),
            'media' => [
                'background' => $media ? $media->path : '',
                'id' => $media ? $media->id : '',
            ]
        ];
    }

    public function detachMedia(Request $request, City $city)
    {
        $city->mediaType($request->input('mediaType'))->detach();

        return [
            'status' => true,
            'msg' => ''
        ];
    }

    public function attachMedia(City $city, Media $media)
    {
        $city->medias()->sync($media);

        return [
            'status' => true,
            'msg' => ''
        ];
    }

    public function change(Request $request, City $city)
    {
        try {
            $city->update([
                'name' => $request->input('name')
            ]);

            return [
                'status' => true,
                'msg' => ''
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'msg' => ''
            ];
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'city.name' => 'required',
            'media.id' => 'exists:media,id'
        ]);

        $city = City::create([
            'name' => $request->input('city.name')
        ]);

        $city->medias()->attach($request->input('media.id'));

        return [
            'status' => true,
            'msg' => ''
        ];
    }
}
