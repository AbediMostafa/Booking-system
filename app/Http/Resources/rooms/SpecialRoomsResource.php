<?php

namespace App\Http\Resources\rooms;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialRoomsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'image'=>$this->image,
            'is_special'=>$this->is_special,
            'is_new'=>$this->is_new,
            'collectionName'=>$this->collection->title,
            'district'=>$this->district,
            'totalScore'=>$this->ratePercent,
            'collectionAddress'=>$this->district,
            'discount'=>$this->when($this->discount, function(){
                return [
                    'amount'=>$this->discount->amount,
                    'started_at'=>$this->discount->started_at,
                    'ended_at'=>(new Carbon($this->discount->ended_at))->timestamp,
                ];
            })
        ];
    }
}
