<?php
namespace App\Repositories\Activity;

use App\Repositories\RepositoryInterface;

interface ActivityRepositoryInterface extends RepositoryInterface
{
    public function getActivity();

    public function saveActivity($comment, $activities);

    public function saveDataToActivity($follow, $activities);
}
