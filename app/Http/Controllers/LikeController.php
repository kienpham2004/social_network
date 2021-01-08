<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use App\Models\Like;

class LikeController extends Controller
{
    public function like(Request $request)
    {
        $like = Like::create([
            'user_id' => Auth::user()->id,
            'post_id' => $request->id,
        ]);

        $result = [
            'user_id' => $like->user_id,
            'post_id' => $like->post_id,
        ];

        return response()->json($result);
    }

    public function unlike($id)
    {
        $like = Like::where([
            ['user_id', Auth::id()],
            ['post_id', $id]
        ]);
        $like->delete();

        $result = [
            'post_id' => $id,
        ];

        return response()->json($result);
    }
}
