<?php
namespace App\Repositories\Like;

use App\Repositories\RepositoryInterface;

interface LikeRepositoryInterface extends RepositoryInterface
{
    public function checkLike($id);

    public function findIdPost($id);

    public function selectLikePostId();

    public function convertArrLike($likes);
}
