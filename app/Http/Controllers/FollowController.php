<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;
use App\Models\Activity;
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
        if (empty($follow)) {
            $data = [
                'status' => config('id.status_fail_404'),
                'message' => trans('mes.fail'),
            ];

            return response()->json($data);
        } else {

            $user = Follow::with('friend')->where('follow_id', $request->id)->first();
            // dd($user);
            $activities = new Activity;
            $activities->user_id = Auth::id();
            $activities->action = config('create_data.follow');
            $activities->notify = json_encode([
                'message' => 'profile.action_follow_history',
                'user_name' => $user->friend->username,  
            ]);
            
            $follow->activities()->save($activities);
            $result = [
                'user_id' => $follow->user_id,
                'follow_id' => $follow->follow_id, 
            ]; 
    
            return response()->json($result);
        }
    }

    public function unfollow($id)
    {
        $followId = $this->followRepo->findIdUser($id);
        if (empty($followId)) {
            $result = [
                'status' => config('id.status_fail_404'),
                'message' => trans('mes.fail'),
            ];

            return response()->json($result);
        } else {
            $unfollow = $this->followRepo->delete($followId);
            $result = [
                'follow_id' => $id, 
            ];
    
            return response()->json($result);
        }
    }
}
