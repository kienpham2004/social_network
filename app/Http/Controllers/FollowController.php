<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;
use App\Models\Activity;
use App\Repositories\Follow\FollowRepositoryInterface;
use App\Repositories\Activity\ActivityRepositoryInterface;

class FollowController extends Controller
{
    protected $followRepo, $activityRepo;

    public function __construct(
        FollowRepositoryInterface $followRepo,
        ActivityRepositoryInterface $activityRepo
    ) {
        $this->followRepo = $followRepo;
        $this->activityRepo = $activityRepo;
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
            $user = $this->followRepo->getFollower($request->id);
            $data = [
                'message' => 'profile.action_follow_history',
                'user_name' => $this->followRepo->getUserRelationFriend($request->id), 
            ];
            $activities = $this->activityRepo->create([
                'user_id' => Auth::id(),
                'action' => config('create_data.follow'),
                'notify' => json_encode($data),
            ]);
            $this->activityRepo->saveDataToActivity($follow, $activities);
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
