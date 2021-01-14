<?php
namespace App\Repositories\Follow;

use App\Repositories\BaseRepository;
use App\Models\Follow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FollowRepository extends BaseRepository implements FollowRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Follow::class;
    }

    public function checkFollow($user_id, $id)
    {
        return DB::table('follows')->where([
            ['follow_id', $user_id],
            ['user_id', $id]
        ])->exists();
    }

    public function findIdUser($id)
    {
        return Follow::where([
            ['user_id', Auth::id()],
            ['follow_id', $id]
        ])->get();
    }
}
