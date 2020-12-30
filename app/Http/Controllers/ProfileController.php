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

class ProfileController extends Controller
{
    public function index()
    {
        $posts = Post::with('images')->where('user_id', Auth::id() )->withCount('users', 'comments')->latest('created_at')->get();
   
        return view('profile', compact('posts'));
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
}
