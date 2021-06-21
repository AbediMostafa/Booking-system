<?php

namespace App\Http\Resources\rooms;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountedRoomsResource extends JsonResource
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
            'collectionName'=>$this->collection->title,
            'isSpecial'=>$this->is_special,
            'isNew'=>$this->is_new,
            'totalScore'=>$this->ratePercent,
            'collectionAddress'=>$this->district,
            'discount'=>[
                'amount'=>$this->discount->amount,
                'started_at'=>$this->discount->started_at,
                'ended_at'=>$this->discount->ended_at,
            ]
        ];
    }
}
