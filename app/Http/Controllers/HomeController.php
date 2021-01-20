<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Repositories\Activity\ActivityRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\Profile\ProfileRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Like\LikeRepositoryInterface;
use App\Repositories\Story\StoryRepositoryInterface;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Models\Comment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $postRepo, $profileRepo, $likeRepo, $storyRepp, $activityRepo;

    public function __construct(
        ProfileRepositoryInterface $profileRepo, 
        PostRepositoryInterface $postRepo,
        LikeRepositoryInterface $likeRepo,
        StoryRepositoryInterface $storyRepo,
        ActivityRepositoryInterface $activityRepo
    ) {
        $this->middleware('checkstatus');
        $this->profileRepo = $profileRepo;
        $this->postRepo = $postRepo;
        $this->likeRepo = $likeRepo;
        $this->storyRepp = $storyRepo;
        $this->activityRepo = $activityRepo;
    }

    public function index()
    {
        $user = $this->profileRepo->getIdFollowingPluckId();
        $suggessForYou = $this->profileRepo->getListSuggess($user);
        $posts = $this->postRepo->getPostLimit($user);
        $likes = $this->likeRepo->selectLikePostId();
        $likeArr = $this->likeRepo->convertArrLike($likes);
        $stories = $this->storyRepp->getListStory();
        $listHistory = $this->activityRepo->getActivity();

        return view('time_line', compact('posts', 'suggessForYou', 'likeArr', 'stories', 'listHistory'));
    }

    public function loadPost(Request $request)
    {
        $id = $request->id;
        $user = $this->profileRepo->getIdFollowingPluckId();
        $posts = $this->postRepo->getPostLoadMore($user, $id);
        $likes = $this->likeRepo->selectLikePostId();
        $likeArr = $this->likeRepo->convertArrLike($likes);

        return view('layouts.load-post', compact('posts', 'likeArr'));
    }

    public function viewComment(Request $request)
    {
        $id = $request->id;
        $commentId = $request->id_comment;
        $user = $this->profileRepo->getIdFollowingPluckId();
        $posts = $this->postRepo->getCommentLoadMore($id, $commentId);
        $likes = $this->likeRepo->selectLikePostId();
        $likeArr = $this->likeRepo->convertArrLike($likes);

        return view('layouts.load-comment', compact('posts', 'likeArr'));
    }
}
