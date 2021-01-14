<?php
namespace App\Repositories\Follow;

use App\Repositories\RepositoryInterface;

interface FollowRepositoryInterface extends RepositoryInterface
{
    public function checkFollow($user_id, $id);

    public function findIdUser($id);
}
