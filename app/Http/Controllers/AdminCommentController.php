<?php

namespace App\Http\Controllers;

use App\Http\Resources\comments\RoomCommentsResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index()
    {
        return RoomCommentsResource::collection(Comment::whereSituation('not_seen')->paginate(10));
    }

    public function search(Request $request)
    {
        return RoomCommentsResource::collection(
            Comment::where('body', 'like', '%' . $request->get('search') . '%')->paginate(10)
        );
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

            return  [
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
            $comment->situation= 'promoted';
            $comment->save();
        });

        try {

            return  [
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
