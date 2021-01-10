<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use App\Models\Like;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user()->following
            ->pluck('id')
            ->toArray();
        $suggessForYou = User::with('following')
            ->withCount('posts')
            ->whereNotIn('id', $user)
            ->orderBy('posts_count', 'desc')
            ->get();
        $posts = Post::with("user", "images", "comments")
            ->whereIn('user_id', $user)
            ->withCount('users', 'comments')
            ->orderBy('created_at', 'desc')
            ->take(config('var_in_controller.equals_3'))
            ->get();
        $likes = Like::select('post_id')
            ->where('user_id', Auth::user()->id)
            ->get();
        $likeArr = Arr::flatten($likes->toArray());

        return view('time_line', compact('posts', 'suggessForYou', 'likeArr'));
    }

    public function loadPost(Request $request)
    {
        $id = $request->id;
        $user = Auth::user()->following
            ->pluck('id')
            ->toArray();
        $posts = Post::with("user", "images", "comments")
            ->whereIn('user_id', $user)
            ->where('id', '<' , $request->id)
            ->withCount('users', 'comments')
            ->orderBy('created_at', 'desc')
            ->take(config('var_in_controller.take_record_3'))
            ->get();
        $likes = Like::select('post_id')
            ->where('user_id', Auth::user()->id)
            ->get();
        $likeArr = Arr::flatten($likes->toArray());
        
        return view('layouts.load-post', compact('posts', 'likeArr'));
    }

    public function viewComment(Request $request)
    {
        $id = $request->id;
        $user = Auth::user()->following
            ->pluck('id')
            ->toArray();
        $posts = Post::with("user", "images", "comments")
            ->whereIn('user_id', $user)
            ->where('id', '<' , $request->id)
            ->withCount('users', 'comments')
            ->orderBy('created_at', 'desc')
            ->take(config('var_in_controller.take_record_3'))
            ->get();
        $likes = Like::select('post_id')
            ->where('user_id', Auth::user()->id)
            ->get();
        $likeArr = Arr::flatten($likes->toArray());

        return view('layouts.load-comment', compact('posts', 'likeArr'));
    }
}
