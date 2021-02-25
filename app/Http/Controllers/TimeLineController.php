<?php

namespace App\Http\Controllers;

use App\Repositories\Activity\ActivityRepositoryInterface;
use App\Repositories\Follow\FollowRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Profile\ProfileRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;

class TimeLineController extends Controller
{
    protected $profileRepo, $postRepo, $followRepo, $activityRepo;

    public function __construct(
        ProfileRepositoryInterface $profileRepo,
        PostRepositoryInterface $postRepo,
        FollowRepositoryInterface $followRepo,
        ActivityRepositoryInterface $activityRepo
    ) {
        $this->profileRepo = $profileRepo;
        $this->postRepo = $postRepo;
        $this->followRepo = $followRepo;
        $this->activityRepo = $activityRepo;
    }

    public function viewUser($username)
    {
        $counts = $this->profileRepo->getUserByUsername($username);
        if ($counts) {
            $posts = $this->postRepo->getPostWithUserImageCommentLatest('user_id', $counts[0]->id);
            $checkFollow = $this->followRepo->checkFollow($counts[0]->id, Auth::user()->id);
            $listHistory = $this->activityRepo->getActivity();

            return view('view_user', compact('counts', 'posts', 'checkFollow', 'listHistory'));
        }

        return redirect()->route('home');
    }
}
