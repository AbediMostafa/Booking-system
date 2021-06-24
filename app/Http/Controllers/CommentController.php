<?php

namespace App\Http\Controllers;

use App\Http\Resources\Rooms\CommentComments;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function commentChilds(Comment $comment)
    {
        return CommentComments::collection($comment->childs);
    }
}
