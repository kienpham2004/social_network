<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use App\Repositories\Profile\ProfileRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Like\LikeRepositoryInterface;
use App\Repositories\Story\StoryRepositoryInterface;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $postRepo, $profileRepo, $likeRepo, $storyRepp;

    public function __construct(
        ProfileRepositoryInterface $profileRepo, 
        PostRepositoryInterface $postRepo,
        LikeRepositoryInterface $likeRepo,
        StoryRepositoryInterface $storyRepp
    ) {
        $this->middleware('checkstatus');
        $this->profileRepo = $profileRepo;
        $this->postRepo = $postRepo;
        $this->likeRepo = $likeRepo;
        $this->storyRepp = $storyRepp;
    }

    public function index()
    {
        $user = $this->profileRepo->getIdFollowingPluckId();
        $suggessForYou = $this->profileRepo->getListSuggess($user);
        $posts = $this->postRepo->getPostLimit($user);
        $likes = $this->likeRepo->selectLikePostId();
        $likeArr = $this->likeRepo->convertArrLike($likes);
        $stories = $this->storyRepp->getListStory();

        return view('time_line', compact('posts', 'suggessForYou', 'likeArr', 'stories'));
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
        $user = $this->profileRepo->getIdFollowingPluckId();
        $posts = $this->postRepo->getPostLoadMore($user, $id);
        $likes = $this->likeRepo->selectLikePostId();
        $likeArr = $this->likeRepo->convertArrLike($likes);

        return view('layouts.load-comment', compact('posts', 'likeArr'));
    }
}
