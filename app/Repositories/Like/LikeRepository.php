<?php
namespace App\Repositories\Like;

use App\Repositories\BaseRepository;
use App\Models\Like;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class LikeRepository extends BaseRepository implements LikeRepositoryInterface
{
    public function getModel()
    {
        return Like::class;
    }

    public function checkLike($id)
    {
        return DB::table('likes')->where([
            ['user_id', Auth::user()->id], 
            ['post_id', $id]
        ])->exists();
    }

    public function findIdPost($id)
    {
        return Like::where([
            ['user_id', Auth::id()],
            ['post_id', $id]
        ])->get();
    }

    public function selectLikePostId()
    {
        return  Like::select('post_id')
        ->where('user_id', Auth::user()->id)
        ->get();
    }

    public function convertArrLike($likes)
    {
        return Arr::flatten($likes->toArray());
    }
}
