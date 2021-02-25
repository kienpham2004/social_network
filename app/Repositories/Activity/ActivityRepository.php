<?php
namespace App\Repositories\Activity;

use App\Repositories\BaseRepository;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityRepository extends BaseRepository implements ActivityRepositoryInterface
{
    public function getModel()
    {
        return Activity::class;
    }

    public function saveActivity($comment, $activities)
    {
        return $comment->activities()->save($activities);
    }

    public function getActivity()
    {
        return Activity::with('actable')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit('var_in_controller.limit_record_activity')
            ->get();
    }

    public function saveDataToActivity($follow, $activities)
    {
        return $follow->activities()->save($activities);
    }
}
