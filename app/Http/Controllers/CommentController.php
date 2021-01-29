<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Activity;
use App\Models\User;
use App\Notifications\CommentNotification;
use App\Repositories\Activity\ActivityRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Profile\ProfileRepositoryInterface;
use App\Events\LikeEvent;

class CommentController extends Controller
{
    protected $commentRepo, $activityRepo, $postRepo, $profileRepo;

    public function __construct(
        ActivityRepositoryInterface $activityRepo, 
        CommentRepositoryInterface $commentRepo,
        PostRepositoryInterface $postRepo,
        ProfileRepositoryInterface $profileRepo
    ) {
        $this->commentRepo = $commentRepo;
        $this->activityRepo = $activityRepo;
        $this->postRepo = $postRepo;
        $this->profileRepo = $profileRepo;
    }

    public function comment(Request $request)
    {
        $post = $this->postRepo->findPostWithUser($request->postId);
        $dataCreateCommet = [
            'content' => $request->valueComment,
            'user_id' => Auth::user()->id,
            'post_id' => $request->postId,
        ];
        $comment = $this->commentRepo->create($dataCreateCommet);
        $data_activities = [
            'message' => 'profile.action_comment_history',
            'user_name' => $post->user->username,
            'post_id' => $post->id,
        ];
        $activities = new Activity;
        $activities->user_id = Auth::user()->id;
        $activities->action = config('status_acotion.comment');
        $activities->notify = json_encode($data_activities);
        $this->activityRepo->saveActivity($comment, $activities);

        $notificationsOfUser = $this->profileRepo->findUserByIdGetFromPost($post->user->id);
        $noti = [
            'user_name' => Auth::user()->username,
            'action' => 'mes.commented',
            'for_you' => 'mes.your_post',
        ];
        $notificationsOfUser->notify(new CommentNotification($noti));
        event(new LikeEvent($noti));

        return view('layouts.item_comment', compact('comment'));
    }

    public function deleteComment($id)
    {
        $comment = $this->commentRepo->find($id);
        if ($this->authorize('delete', $comment)) {
            $this->commentRepo->delete($id);

            return response()->json(['success' => 'ok']);
        }
    }

    public function editComment(Request $request, $id)
    {
        $comment = $this->commentRepo->find($id);

        if ($this->authorize('update', $comment)) {
            $data = [
                'content' => $request->valueEditComment,
            ];
            $this->commentRepo->update($id, $data);
                  
            return view('layouts.edit_comment', compact('comment'));
        }
    }
}
