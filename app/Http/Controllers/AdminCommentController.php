<?php

namespace App\Http\Controllers;

use App\Http\Resources\comments\RoomCommentsResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCommentController extends Controller
{
    public function index(Request $request)
    {

        $comments = Comment::when(
            $request->input('commentType') === 'unApproved',
            function ($query) {
                $query->whereSituation('not_seen');
            },
            function ($query) {
                $query->whereParentId(null)->whereSituation('promoted');
            }
        )->when(
            Auth::user()->type === 'room_owner',
            function ($query) {

                $query->whereHas('commentable', function ($room) {
                    $roomIds = Auth::user()->rooms->pluck('id');
                    $room->whereIn('id', $roomIds);
                });
            }
        )->when(
            $request->input('search'),
            function ($query) use ($request){
                $query->whereHas('commentable', function ($room) use ($request){
                    $room->where('name', 'like', '%'.$request->input('search').'%');
                });
            }
        )->with('childs')->paginate(10);

        return RoomCommentsResource::collection($comments);
    }

    public function search(Request $request)
    {
        $comments = Comment::when(
            $request->input('commentType') === 'unApproved',
            function ($query) {
                $query->where('situation', 'not_seen');
            }
        )->when(
            Auth::user()->type === 'room_owner',
            function ($query) {

                $query->whereHas('commentable', function ($room) {
                    $roomIds = Auth::user()->rooms->pluck('id');
                    $room->whereIn('id', $roomIds);
                });
            }
        )->where('body', 'like', '%' . $request->get('search') . '%')->paginate(10);

        return RoomCommentsResource::collection($comments);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'comments' => 'required|array',
            'comments.*' => 'exists:comments,id',
        ]);

        tryCatch(function () use ($request) {
            Comment::destroy(\request('comments'));
        }, 'نظرها با موفقیت حذف شدند.', 'مشکل در حذف نظرها');
    }

    public function grant(Request $request)
    {
        $request->validate([
            'comments' => 'required|array',
            'comments.*' => 'exists:comments,id',
        ]);

        return tryCatch(function () use ($request) {

            Comment::whereIn('id', $request->input('comments'))->get()->each(function ($comment) {
                $comment->situation = 'promoted';
                $comment->save();
            });

        }, 'نظرها با موفقیت دارای مجوز شدند.', 'مشکل در دادن مجوز به نظرها');
    }
}
