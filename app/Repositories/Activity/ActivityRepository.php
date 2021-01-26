<?php
namespace App\Repositories\Activity;

use App\Repositories\BaseRepository;
use App\Models\Activity;

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
}
