<?php

namespace App\Http\Controllers;

use App\Repositories\Follow\FollowRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Profile\ProfileRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;

class TimeLineController extends Controller
{
    protected $profileRepo, $postRepo, $followRepo;

    public function __construct(
        ProfileRepositoryInterface $profileRepo,
        PostRepositoryInterface $postRepo,
        FollowRepositoryInterface $followRepo
    ) {
        $this->profileRepo = $profileRepo;
        $this->postRepo = $postRepo;
        $this->followRepo = $followRepo;
    }

    public function viewUser($username)
    {
        $counts = $this->profileRepo->getUserByCondition('username', $username, ['follower', 'following']);
        if (!$counts->count()) {
                abort(404);
        } else {
            $posts = $this->postRepo->getPostWithUserImageCommentLatest('user_id', $counts[0]->id);
            $checkFollow = $this->followRepo->checkFollow($counts[0]->id, Auth::user()->id);
            
            return view('view_user', compact('counts', 'posts', 'checkFollow'));
        }
   }
}
