<?php
namespace App\Repositories\Post;

use App\Repositories\BaseRepository;
use App\Models\Post;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function getModel()
    {
        return Post::class;
    }

    public function getPostLatest($id)
    {
        return Post::with('images')
            ->where('user_id', $id )
            ->withCount('users', 'comments')
            ->latest('created_at')
            ->get();
    }

    public function getPostWhereIdExists($id)
    {
        return Post::where('id', $id)->exists();
    }

    public function getPosts($id){
        return Post::with('user', 'images', 'comments')
            ->withCount('users')
            ->where('id', $id)->get();
    }

    public function getPostWithUserImageCommentLatest($colunm , $value)
    {
        return Post::with('user', 'images', 'comments')
            ->where($colunm, $value )
            ->withCount('users', 'comments')
            ->latest('created_at')
            ->get();
    }

    public function getPostLimit($user)
    {
        return Post::with("user", "images", "comments")
            ->whereIn('user_id', $user)
            ->withCount('users', 'comments')
            ->orderBy('created_at', 'desc')
            ->take(config('var_in_controller.take_record_3'))
            ->get();
    }

    public function getPostLoadMore($user, $id)
    {
        return Post::with("user", "images", "comments")
            ->whereIn('user_id', $user)
            ->where('id', '<' , $id)
            ->withCount('users', 'comments')
            ->orderBy('created_at', 'desc')
            ->take(config('var_in_controller.take_record_3'))
            ->get();
    }
}
