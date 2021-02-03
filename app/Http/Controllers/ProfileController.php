<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadAvatarRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostStatusRequest;
use App\Http\Requests\StoryRequest;
use App\Models\Image;
use App\Models\Story;
use App\Repositories\Follow\FollowRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Repositories\Like\LikeRepositoryInterface;
use App\Repositories\Profile\ProfileRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use App\Models\User;
use App\Repositories\Story\StoryRepositoryInterface;

class ProfileController extends Controller
{
    protected $profileRepo, $postRepo, $likeRepo, $followRepo, $storyRepo;

    public function __construct(
        ProfileRepositoryInterface $profileRepo, 
        PostRepositoryInterface $postRepo,
        LikeRepositoryInterface $likeRepo,
        FollowRepositoryInterface $followRepo,
        StoryRepositoryInterface $storyRepo
    ) {
        $this->profileRepo = $profileRepo;
        $this->postRepo = $postRepo;
        $this->likeRepo = $likeRepo;
        $this->followRepo = $followRepo;
        $this->storyRepo = $storyRepo;
    }

    public function index()
    {    
        $id = Auth::user()->id;
        $posts = $this->postRepo->getPostLatest($id);
        $counts = $this->profileRepo->loadFollowerAndCountFollower($id);
        $users = $this->profileRepo->getFollowerAndFollowing();
        $following = $users->following;
        $followers = $users->follower;

        return view('profile', compact('posts', 'counts', 'following', 'followers'));
    }

    public function postStatus(PostStatusRequest $request)
    {
        if ($request->hasFile('imageFile')) {
            $data = [ 
                'caption' => $request->caption,
                'user_id' => Auth::user()->id,
            ];
            $post = $this->postRepo->create($data);
            foreach($request->file('imageFile') as $key => $file)
            {
                $name = rand() . "." . $file->getClientOriginalExtension();
                $file->move(public_path() . '/image/', $name);
                $nameImages[] = [
                    'photo_url' => $name,
                    'post_id' => $post->id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];  
            }

            Image::insert($nameImages);
            toastr()->success( trans('profile.data_has_been_saved_successfully') );
            
            return back();
        } 
    }

    public function uploadAvatar(UploadAvatarRequest $request, $id)
    {
        $user = $this->profileRepo->find($id);

        if ($request->file('avatarFile')) {
            $imagePath = $request->file('avatarFile');
            $imageName = rand() . "." . $imagePath->getClientOriginalExtension();
            $path = $request->file('avatarFile')->move(public_path() . '/avatar/', $imageName);
        }
        $user->avatar = $imageName;
        $user->save();

        return redirect()->back(); 
    }

    public function showPost($id)
    {
        $check = $this->postRepo->getPostWhereIdExists($id);
        if (!$check) {
            abort(404);
        } else {
            $post = $this->postRepo->getPosts($id);
            foreach ($post as $item) {
                $checkLike = $this->likeRepo->checkLike($item->id);
            }
            
            return view('show-post', compact('post', 'checkLike'));
        }
    }

    public function back($id)
    {   
        $idUser = Auth::user()->id;
        $check = $this->postRepo->getPostWhereIdExists($id);
        if (!$check) {
            abort(404);
        } else {
            $counts = $this->profileRepo->loadFollowerAndCountFollower($idUser);
            $post = $this->postRepo->getPostWithUserImageCommentLatest('id', $id);
            foreach ($post as $item) {
                if ($item->user_id == $idUser) {
                    $users = $this->profileRepo->getFollowerAndFollowing();
                    $following = $users->following;
                    $followers = $users->follower;
                    $checkFollow = $this->followRepo->checkFollow($item->user_id, $idUser);
                    $posts = $this->postRepo->getPostLatest($idUser);
                    $counts = $this->profileRepo->loadFollowerAndCountFollower($idUser);
                        
                    return view('profile', compact('posts', 'counts', 'users', 'following', 'followers', 'checkFollow'));
                } else {
                    $users = $this->profileRepo->getFollowerAndFollowing();
                    $following = $users->following;
                    $followers = $users->follower;
                    $user = $this->profileRepo->getUserByCondition('username', $item->user->username);
                    $checkFollow = $this->followRepo->checkFollow($item->user_id, $idUser);
                    $posts = $this->postRepo->getPostWithUserImageCommentLatest('user_id', $user[0]->id);
                    $counts =  $this->profileRepo->loadFollowerAndCountFollower($idUser);

                    return view('view_user', compact('posts', 'counts', 'users', 'following', 'followers', 'checkFollow'));
            }
        }
        }
    }

    public function createStory(Request $request)
    {
        if ($request->file('imageStory')) {
            $imagePath = $request->file('imageStory');
            $imageName = rand() . "." . $imagePath->getClientOriginalExtension();
            $path = $request->file('imageStory')->move(public_path() . config('url.url_story') , $imageName);

            $data = [
                'user_id' => Auth::user()->id,
                'content' => $request->content,
                'url_image_story' => $imageName,
            ];
            $this->storyRepo->create($data);
            toastr()->success(trans('timelime.post_story_success'));

            return redirect()->back();
        }
        toastr()->error(trans('timeline.post_story_failed'));

        return redirect()->back();
    }
}
