<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;
use App\Repositories\Follow\FollowRepositoryInterface;

class FollowController extends Controller
{
    protected $followRepo;

    public function __construct(FollowRepositoryInterface $followRepo)
    {
        $this->followRepo = $followRepo;
    }

    public function follow(Request $request)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'follow_id' => $request->id,
        ];
        $follow = $this->followRepo->create($data);
        $result = [
            'user_id' => $follow->user_id,
            'follow_id' => $follow->follow_id, 
        ]; 

        return response()->json($result);
    }

    public function unfollow($id)
    {
        $follow = $this->followRepo->findIdUser($id);
        $unfollow = $this->followRepo->delete($follow->first()->id);
        $result = [
            'follow_id' => $id, 
        ];

        return response()->json($result);
    }
}
