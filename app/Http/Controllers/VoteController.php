<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function submitVote($type, Comment $comment)
    {
        try {
            $votedBefore = $comment->agreements()->whereUserId(Auth::id())->first();

            if ($votedBefore) {
                if ($votedBefore->status == $type) {
                    $votedBefore->delete();
                    return $type == 'agree' ? $this->returnStatus(0, 1, 0, 0) : $this->returnStatus(0, 0, 0, 1);
                }

                $votedBefore->status = $type;
                $votedBefore->save();

                return $type == 'agree' ? $this->returnStatus(1, 0, 0, 1) : $this->returnStatus(0, 1, 1, 0);
            }

            $comment->agreements()->create([
                'status' => $type,
                'user_id' => Auth::id()
            ]);


            return $type == 'agree' ? $this->returnStatus(1, 0, 0, 0) : $this->returnStatus(0, 0, 1, 0);
        } catch (\Throwable $th) {
            return $this->returnStatus(0, 0, 0, 0, 0);
        }
    }

    public function returnStatus($increaseAgree, $decreaseAgree, $increaseDisagree, $decreaseDisagree, $status = 1)
    {
        return [
            'increaseAgree' => $increaseAgree,
            'decreaseAgree' => $decreaseAgree,
            'increaseDisagree' => $increaseDisagree,
            'decreaseDisagree' => $decreaseDisagree,
            'status' => $status
        ];
    }
}
