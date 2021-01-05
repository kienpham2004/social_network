<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimeLineController extends Controller
{
    public function viewUser($username)
    {
        $counts = User::where('username', $username)->withCount('follower', 'following')->get();
        if (!$counts->count()) {
                abort(404);
        } else {
            $posts = Post::with('user', 'images', 'comments')->where('user_id', $counts[0]->id)->withCount('users', 'comments')->orderBy('created_at', 'desc')->get();
            $checkFollow = DB::table('follows')->where([
                ['follow_id', $counts[0]->id],
                ['user_id', Auth::user()->id]
            ])->exists();
            
            return view('view_user', compact('counts', 'posts', 'checkFollow'));
        }
   }
}
