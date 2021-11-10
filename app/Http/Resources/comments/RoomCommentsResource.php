<?php

namespace App\Http\Resources\comments;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class RoomCommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $roomId = $this->commentable->id;
        $userRate = $this->user
            ->rates()
            ->where('room_id', $roomId)
            ->first();

        $isNotAnswer = $this->parent_id === null;

        //~~ room owner's comment
        $isRoomOwnersComment = function ($comment) {
            $roomOwnerIds = $comment->commentable->user->pluck('id')->toArray();
            return in_array($comment->user->id, $roomOwnerIds);
        };

        //~~ moving room owners's comment to top
        $childs = $this->childs->filter($isRoomOwnersComment)->merge(
            $this->childs->reject($isRoomOwnersComment)
        );

        return [
            'id' => $this->id,
            'body' => $this->body,
            'up_rate' => $this->agreements()->whereStatus('agree')->count(),
            'down_rate' => $this->agreements()->whereStatus('disagree')->count(),
            'status' => $this->status,
            'isComment' => $isNotAnswer,
            'situation' => $this->situation,
            'room' => $this->commentable->name,
            'roomId' => $this->commentable->id,
            'date' => \Morilog\Jalali\Jalalian::forge($this->created_at)->format('%A %d %B %Y'),
            'childs' => AdminAnswerResource::collection($childs),
            'rates' => $this->when($isNotAnswer, function () use ($userRate) {
                return [
                    'scariness' => $userRate->scariness,
                    'room_decoration' => $userRate->room_decoration,
                    'hobbiness' => $userRate->hobbiness,
                    'creativeness' => $userRate->creativeness,
                    'mysteriness' => $userRate->mysteriness,
                ];
            }),
            'user' => [
                'rate' => $this->when($isNotAnswer, $userRate ? $userRate->rateAveragePercent : 0),
                'name' => $this->user->name,
                'is_owner' => Auth::check() && Auth::id() == $this->user->id ? 1 : 0
            ],
        ];
    }
}
