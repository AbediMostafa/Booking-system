<?php

namespace App\Http\Controllers;

use App\Http\Resources\comments\RoomCommentsResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::when($request->input('commentType') === 'unApproved', function ($query) {
            $query->where('situation', 'not_seen');
        })->paginate(10);

        return RoomCommentsResource::collection($comments);
    }

    public function search(Request $request)
    {

        $comments = Comment::when($request->input('commentType') === 'unApproved', function ($query) {
            $query->where('situation', 'not_seen');
        })->where('body', 'like', '%' . $request->get('search') . '%')->paginate(10);

        return RoomCommentsResource::collection($comments);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'comments' => 'required|array',
            'comments.*' => 'exists:comments,id',
        ]);

        Comment::whereIn('id', $request->input('comments'))->get()->each(function ($comment) {
            $comment->delete();
        });

        try {

            return [
                'status' => true,
                'msg' => 'نظرها با موفقیت حذف شدند.'
            ];
        } catch (\Throwable $th) {

            return [
                'status' => false,
                'msg' => 'مشکل در حذف نظرها'
            ];
        }
    }

    public function grant(Request $request)
    {
        $request->validate([
            'comments' => 'required|array',
            'comments.*' => 'exists:comments,id',
        ]);

        Comment::whereIn('id', $request->input('comments'))->get()->each(function ($comment) {
            $comment->situation = 'promoted';
            $comment->save();
        });

        try {

            return [
                'status' => true,
                'msg' => 'نظرها با موفقیت دارای مجوز شدند.'
            ];
        } catch (\Throwable $th) {

            return [
                'status' => false,
                'msg' => 'مشکل در دادن مجوز به نظرها'
            ];
        }
    }
}
