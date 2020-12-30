<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $follow = Follow::create([
            'user_id' => Auth::user()->id,
            'follow_id' => $request->id,
        ]);
    
        $result = [
            'user_id' => $follow->user_id,
            'follow_id' => $follow->follow_id, 
        ]; 

        return response()->json($result);
    }

    public function unfollow($id)
    {
        $follow = Follow::where([
            ['user_id', Auth::id()],
            ['follow_id', $id]
        ]);
        $follow->delete();
      
        $result = [
            'follow_id' => $id, 
        ];

        return response()->json($result);
    }
}
