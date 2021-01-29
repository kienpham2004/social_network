<?php
namespace App\Repositories\Profile;

use App\Repositories\BaseRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function loadFollowerAndCountFollower($id)
    {
        return User::where('id', $id)
            ->withCount('follower', 'following')
            ->get();
    }

    public function getUserByCondition($column, $value, $withCount = [], $with = [] )
    {
        return User::with($with)->withCount($withCount)->where($column, $value)->get();
    }

    public function getUserByUsername($value)
    {
        return User::with('posts')->withCount('follower', 'following')->where('username', $value)->get();
    }

    public function getFollowerAndFollowing()
    {
        return Auth::user()
            ->load('follower', 'following')
            ->loadCount('follower', 'following');
    }

    public function getIdFollowingPluckId()
    {
        return Auth::user()->following
            ->pluck('id')
            ->toArray();
    }
    
    public function getListSuggess($user)
    {
        return User::with('following')
            ->withCount('posts')
            ->whereNotIn('id', $user)
            ->orderBy('posts_count', 'desc')
            ->get();
    }

    public function getValueSearch($column, $value)
    {
        return User::where($column, 'like', '%' . $value . '%')->get();
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->get();
    }

    public function getUserFirstByEmail($email)
    {
        $user = User::where('email', $email)->first();

        return $user;
    }

    public function updateOtpWhenFindEmail($email)
    {
        $user = User::where('email', $email)->first();

        return $user->update([
            'OTP' => rand(100000, 999999),
        ]);
    }

    public function getOTPUser($email)
    {
        $user = User::where('email', $email)->first();

        return $user->OTP;
    }

    public function updatePasswordAndOtp($email, $password)
    {
        $user = User::where('email', $email)->first();

        return $user->update([
            'password' => Hash::make($password),
            'OTP' => null,
        ]);
    }

    public function findUserByIdGetFromPost($id)
    {
        return User::findOrFail($id);
    }
}
