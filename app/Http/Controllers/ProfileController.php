<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $posts = Post::with('images')->where('user_id', Auth::id() )->withCount('users', 'comments')->latest('created_at')->get();
   
        return view('profile', compact('posts'));
    }
}
