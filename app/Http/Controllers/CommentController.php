<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Activity;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
        $comment = new Comment;
        $post = Post::with('user')->findOrFail($request->postId);
        $comment->content = $request->valueComment;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->postId;
        
        $comment->save();
        $activities = new Activity;
        $activities->user_id = Auth::user()->id;
        $activities->action = config('status_acotion.comment');
        $activities->notify = json_encode([
            'message' => 'profile.action_comment_history',
            'user_name' => $post->user->username,
            'post_id' => $post->id,
        ]);
        $comment->activities()->save($activities);

        return view('layouts.item_comment', compact('comment'));
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
   
        if ($this->authorize('delete', $comment)) {
            $comment->delete($id);

            return response()->json(['success' => 'ok']);
        }
    }

    public function editComment(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($this->authorize('update', $comment)) {
            $comment->update([
                'content' => $request->valueEditComment,
            ]);
                  
            return view('layouts.edit_comment', compact('comment'));
        }
    }
}
