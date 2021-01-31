<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Like\LikeRepositoryInterface;
use App\Models\User;
use App\Notifications\LikeNotication;
use App\Repositories\Profile\ProfileRepositoryInterface;

class LikeController extends Controller
{
    protected $likeRepo, $profileRepo;

    public function __construct(
        LikeRepositoryInterface $likeRepo,
        ProfileRepositoryInterface $profileRepo
    ) {
        $this->likeRepo = $likeRepo;
        $this->profileRepo = $profileRepo;
    }

    public function like(Request $request)
    {   
        $data = [
            'user_id' => Auth::user()->id,
            'post_id' => $request->id,
        ];
        $like = $this->likeRepo->create($data);
        if (empty($like)) {
            $data = [
                'status' => config('id.status_fail_404'),
                'message' => trans('mes.fail'),
            ];

            return response()->json($data);
        } else {
            $result = [
                'user_id' => $like->user_id,
                'post_id' => $like->post_id,
                'id_user_noti' => $request->user_id,
            ];
            $notificationsOfUser = $this->profileRepo->findUserByIdGetFromPost($request->user_id);
            $noti = [
                'user_name' => Auth::user()->username,
                'action' => 'mes.liked',
                'for_you' => 'mes.your_post',
            ];

            $notificationsOfUser->notify(new LikeNotication($noti));
    
            return response()->json($result);
        }
    }

    public function unlike(Request $request, $id)
    {
        $like = $this->likeRepo->findIdPost($id);
        if (empty($like)) {
            $data = [
                'status' => config('id.status_fail_404'),
                'message' => trans('mes.fail'),
            ];

            return response()->json($data);
        } else {
            $likeDelete = $this->likeRepo->delete($like->first()->id);
            $result = [
                'post_id' => $id,
                'id_user_noti' => $request->user_id,
            ];
    
            return response()->json($result);
        }
    }
}
