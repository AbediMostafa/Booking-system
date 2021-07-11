<?php

namespace App\Http\Controllers;

use App\Http\Resources\comments\AnswerResource;
use App\Models\Comment;
use App\Models\Rate;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function answers(Comment $comment)
    {
        return AnswerResource::collection($comment->childs->paginate(4));
    }

    public function submitComment(Request $request)
    {

        $request->validate([
            'comment' => 'required',
            'scoresTitles.scariness.selectedKey' => 'required',
            'scoresTitles.room_decoration.selectedKey' => 'required',
            'scoresTitles.hobbiness.selectedKey' => 'required',
            'scoresTitles.creativeness.selectedKey' => 'required',
            'scoresTitles.mysteriness.selectedKey' => 'required',
        ]);

        $room = Room::findOrFail($request->input('roomInfo.id'));

        try {

            $room->rates()->create([
                'room_id' => $request->input('roomInfo.id'),
                'user_id' => Auth::id(),
                'scariness' => $request->input('scoresTitles.scariness.selectedKey'),
                'room_decoration' => $request->input('scoresTitles.room_decoration.selectedKey'),
                'hobbiness' => $request->input('scoresTitles.hobbiness.selectedKey'),
                'creativeness' => $request->input('scoresTitles.creativeness.selectedKey'),
                'mysteriness' => $request->input('scoresTitles.mysteriness.selectedKey'),
            ]);

            $room->comments()->create([
                'user_id' => Auth::id(),
                'status' => $request->input('selectedStatus'),
                'body' => $request->input('comment')
            ]);

            return [
                'status'=>true,
                'msg'=>'نظر شما با موفقیت ثبت، و پس از بررسی اضافه خواهد شد'
            ];
        } catch (\Throwable $th) {
            return [
                'status'=>true,
                'msg'=>'مشکل در ثبت نظر'
            ];
        }
    }
}
