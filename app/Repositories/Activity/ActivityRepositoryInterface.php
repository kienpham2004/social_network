<?php
namespace App\Repositories\Activity;

use App\Repositories\RepositoryInterface;

interface ActivityRepositoryInterface extends RepositoryInterface
{
    public function saveActivity($comment, $activities);
}
