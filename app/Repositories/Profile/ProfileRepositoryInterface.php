<?php
namespace App\Repositories\Profile;

use App\Repositories\RepositoryInterface;

interface ProfileRepositoryInterface extends RepositoryInterface
{
   public function loadFollowerAndCountFollower($id);

   public function getUserByCondition($column, $value, $with, $withCount);

   public function getUserByUsername($value);

   public function getFollowerAndFollowing();

   public function getIdFollowingPluckId();

   public function getListSuggess($user);  

   public function getValueSearch($column, $value);

   public function getUserByEmail($email);

   public function getUserFirstByEmail($email);

   public function updateOtpWhenFindEmail($email);

   public function getOTPUser($email);

   public function updatePasswordAndOtp($email, $password);

   public function findUserByIdGetFromPost($id);
}
