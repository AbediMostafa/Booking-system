<?php

namespace App\Http\Controllers;

use App\Http\Resources\comments\AnswerResource;
use App\Models\Comment;

class CommentController extends Controller
{
    public function answers(Comment $comment)
    {
        return AnswerResource::collection($comment->childs->paginate(4));
    }
}
