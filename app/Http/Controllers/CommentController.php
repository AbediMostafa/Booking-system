<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitCommentRequest;
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

    public function submitComment(SubmitCommentRequest $request)
    {
        $room = Room::findOrFail($request->input('roomInfo.id'));

        $ratedBefore = Rate::where([
            ['room_id', $request->input('roomInfo.id')],
            ['user_id', Auth::id()]
        ])->exists();

        $commentedBefore = Comment::where([
            ['commentable_id', $request->input('roomInfo.id')],
            ['parent_id', null],
            ['user_id', Auth::id()]
        ])->exists();

        if ($ratedBefore || $commentedBefore) {
            return [
                'status' => false,
                'msg' => ''
            ];
        }

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
                'status' => true,
                'msg' => ''
            ];
        } catch (\Throwable $th) {
            return [
                'status' => true,
                'msg' => 'success'
            ];
        }
    }

    public function editComment(SubmitCommentRequest $request, Room $room)
    {

        $room->rates()->where('user_id', Auth::id())->update([
            'creativeness' => $request->input('scoresTitles.creativeness.selectedKey'),
            'hobbiness' => $request->input('scoresTitles.hobbiness.selectedKey'),
            'mysteriness' => $request->input('scoresTitles.mysteriness.selectedKey'),
            'room_decoration' => $request->input('scoresTitles.room_decoration.selectedKey'),
            'scariness' => $request->input('scoresTitles.scariness.selectedKey'),
        ]);

        $room->comments()->where('user_id', Auth::id())->update([
            'body' => $request->input('comment'),
            'status' => $request->input('selectedStatus'),
            'situation' => 'not_seen'
        ]);

        return [
            'status' => true,
            'msg' => ''
        ];
    }

    public function answerToComment(Request $request, Comment $comment): array
    {
        $request->validate([
            'answer' => 'required'
        ]);

        $successMsg = $this->isSuperUser() ? '' : '';

        return tryCatch(function () use ($comment, $request) {

            $comment->childs()->create([
                'body' => $request->input('answer'),
                'commentable_id' => $comment->commentable_id,
                'commentable_type' => 'room',
                'user_id' => Auth::id(),
                'status' => 'agree',
                'situation' => $this->isSuperUser() ? 'promoted' : 'not_seen'
            ]);

        }, $successMsg, 'error');
    }

    public function isSuperUser()
    {

        $responder = Auth::user()->type;

        return $responder === 'room_owner' || $responder === 'manager' || $responder === 'admin';

    }
}
