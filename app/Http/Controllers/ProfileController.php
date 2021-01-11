<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\UploadAvatarRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostStatusRequest;
use App\Models\Image;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Activity;

class ProfileController extends Controller
{
    public function index()
    {    
        $id = Auth::user()->id;
        $posts = Post::with('images')->where('user_id', $id )->withCount('users', 'comments')->latest('created_at')->get();
        $counts = User::where('id', $id)->withCount('follower', 'following')->get();
        $users = Auth::user()->load('follower')->loadCount('follower', 'following');
        $following = $users->following;
        $followers = $users->follower;

        return view('profile', compact('posts', 'counts', 'following', 'followers'));
    }

    public function postStatus(PostStatusRequest $request)
    {
        if ($request->hasFile('imageFile')) {
            $post = Post::create([
                'caption' => $request->caption,
                'user_id' => Auth::id(),
            ]);

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
        $user = User::findOrFail($id);

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
        $check = Post::where('id', $id)->exists();
        if (!$check) {
            abort(404);
        } else {
            $posts = Post::with('user', 'images', 'comments')
                ->withCount('users')
                ->where('id', $id)->get();

            foreach ($posts as $item) {
                $checkLike = DB::table('likes')->where([
                    ['user_id', Auth::user()->id], 
                    ['post_id', $item->id]
                ])->exists();
            }
            
            return view('show-post', compact('post', 'checkLike'));
        }
    }

    public function back($id)
    {   
        $idUser = Auth::user()->id;
        $check = Post::where('id', $id)->exists();
        if (!$check) {
            abort(404);
        } else {
            $counts = User::where('id', $idUser)->withCount('follower', 'following')->get();
            $post = Post::with('user', 'images', 'comments')->where('id', $id )->withCount('users', 'comments')->latest('created_at')->get();
            foreach ($post as $item) {
                if ($item->user_id == $idUser) {
                    $users = Auth::user()->load('follower')->loadCount('follower', 'following');
                    $following = $users->following;
                    $followers = $users->follower;
                    $checkFollow = DB::table('follows')->where([
                        ['follow_id', $item->user_id],
                        ['user_id', $idUser]
                    ])->exists();
                    $posts = Post::with('images')->where('user_id', $idUser)->withCount('users', 'comments')->latest('created_at')->get();
                    $counts = User::where('id', $idUser)->withCount('follower', 'following')->get();

                    return view('profile', compact('posts', 'counts', 'users', 'following', 'followers', 'checkFollow'));
                } else {
                    $users = Auth::user()->load('follower', 'following')->loadCount('follower', 'following');
                    $following = $users->following;
                    $followers = $users->follower;
                    $checkFollow = DB::table('follows')->where([
                        ['follow_id', $item->user_id],
                        ['user_id', $idUser]
                    ])->exists();
                    $user = User::where('username', $item->user->username)->get();
                    $posts = Post::with('user', 'images', 'comments')->where('user_id', $user[0]->id)->withCount('users', 'comments')->orderBy('created_at', 'desc')->get();
                    $counts = User::where('id', $idUser)->withCount('follower', 'following')->get();

                    return view('view_user', compact('posts', 'counts', 'users', 'following', 'followers', 'checkFollow'));
            }
        }
        }
    }
}
