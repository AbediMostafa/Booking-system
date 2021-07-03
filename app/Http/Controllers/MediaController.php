<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaStoreRequest;
use App\Http\Requests\FormRoomRequest;
use App\Models\City;
use App\Models\Collection;
use App\Models\Discount;
use App\Models\Media;
use App\Models\Room;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class MediaController extends Controller
{
    public function index()
    {
        return Media::select('id', 'display_name', 'path')->paginate(12);
    }

    public function search(Request $request)
    {
        return Media::select('id', 'display_name', 'path')
            ->where('display_name','like', '%'.$request->get('search').'%')
            ->paginate(12);
    }

    public function filter(Request $request)
    {
        return Media::when($request->get('filter'), function($query) use ($request){
            $query->where('media_of', $request->get('filter'));
        })->paginate(12);
    }

    public function upload(MediaStoreRequest $request)
    {
        $pathStore = date('y/m');
        $path = $request->file('file')->store("pubic/uploads/$pathStore");

        $publicPath = str_replace('public', 'storage', $path);
        $fileName = $request->file('file')->hashName();
        Media::create([
            'display_name' => $request->file('file')->getClientOriginalName(),
            'store_name' => $fileName,
            'path' => $publicPath,
            'type' => substr($request->file('file')->getMimeType(), 0, 5),
            'media_of' => $request->media_of,
            'mediaable_id' => null,
            'mediaable_type' => null,
        ]);
    }

    public function delete(Request $request)
    {
        //medias
        //array, 

        $request->validate([
            'medias' => 'array|required',
            'medias.*' => 'exists:medias,id'
        ]);

        try {
            Media::whereIn('id', $request->get('medias'))->get()->each(function ($media) {
                $media->delete();
            });

            return[
                'status'=>true,
                'msg'=>'مدیاها با موفقیت حذف شدند'
            ];

        } catch (\Throwable $th) {
            return [
                'status'=>false,
                'msg'=>'مشکل در حذف مدیاها'
            ];
        }

        
    }
    public function formRoom(FormRoomRequest $request)
    {
        Room::create([          
            'address' => $request->input('room.address'),
            'city_id' => City::where('name',$request->input('room.city_id'))->rooms->id,
            'collection_id' => Collection::where('title',$request->input('room.collection_id'))->rooms->id,
            'description' => $request->input('room.description'),
            'district' => $request->input('room.district'),
            'game_time' => $request->input('room.game_time'),
            'hardness' => $request->input('room.hardness'),
            'is_new' => $request->input('room.is_new'),
            'is_special' => $request->input('room.is_special'),
            'max_person' => $request->input('room.max_person'),
            'mobile' => $request->input('room.mobile'),
            'name' => $request->input('room.name'),
            'phone' => $request->input('room.phone'),
            'price' => $request->input('room.price'),
        ]);
        $started=Jalalian::fromFormat('Y/m/d',$request->input('discount.started_at'))->toCarbon()->toDateString();
        $ended=Jalalian::fromFormat('Y/m/d',$request->input('discount.ended_at'))->toCarbon()->toDateString();
        if($request->hasDiscount){
            Discount::create([                
                'amount' => $request->input('discount.amount'),
                'started_at' => $started,
                'ended_at' =>$ended,
            ]);
        }
    }
}
