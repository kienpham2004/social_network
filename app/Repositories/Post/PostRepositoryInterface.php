<?php
namespace App\Repositories\Post;

use App\Repositories\RepositoryInterface;

interface PostRepositoryInterface extends RepositoryInterface
{
   public function getPostLatest($id);

   public function getPostWhereIdExists($id);

   public function getPosts($id);

   public function getPostWithUserImageCommentLatest($colunm, $value);

   public function getPostLimit($user);

   public function getPostLoadMore($user, $id);

   public function findPostWithUser($id);
}
