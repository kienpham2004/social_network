<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use App\Models\Like;
use App\Repositories\Like\LikeRepositoryInterface;

class LikeController extends Controller
{
    protected $likeRepo;

    public function __construct(LikeRepositoryInterface $likeRepo)
    {
        $this->likeRepo = $likeRepo;
    }

    public function like(Request $request)
    {   
        $data = [
            'user_id' => Auth::user()->id,
            'post_id' => $request->id,
        ];
        $like = $this->likeRepo->create($data);
        $result = [
            'user_id' => $like->user_id,
            'post_id' => $like->post_id,
        ];

        return response()->json($result);
    }

    public function unlike($id)
    {
        $like = $this->likeRepo->findIdPost($id);
        $likeDelete = $this->likeRepo->delete($like->first()->id);
        $result = [
            'post_id' => $id,
        ];

        return response()->json($result);
    }
}
