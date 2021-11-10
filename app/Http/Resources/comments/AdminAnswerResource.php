<?php

namespace App\Http\Resources\comments;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'status' => $this->status,
            'situation' => $this->situation,
            'date' => \Morilog\Jalali\Jalalian::forge($this->created_at)->format('%A %d %B %Y'),
            'user' => $this->getUsername(),
            'userIsManager'=> $this->when($this->userIsManager(), 1)
        ];
    }

    public function userIsManager():string
    {
        return $this->user->type === 'admin' || $this->user->type === 'manager';
    }

    public function getUsername()
    {
        //~~ room owners
        $roomOwnerIds = $this->commentable->user->pluck('id')->toArray();

        if ($this->userIsManager()) {
            return 'ادمین سایت';
        }

        return in_array($this->user->id, $roomOwnerIds) ? 'صاحب مجموعه' : $this->user->name;
    }
}
