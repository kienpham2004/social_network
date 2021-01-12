<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;


class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $user;

    protected function setUp(): void
    {
        $this->user = new User();
        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->user = null;
        parent::tearDown();
    }

    public function test_user_contains_valid_fillable_properties()
    {
        $this->assertEquals([
            'username',
            'role_id',
            'email',
            'password',
            'description',
            'fullname',
            'status',
            'avatar',
        ], $this->user->getFillable());
    }

    public function test_user_contains_valid_hidden_properties()
    {
        $this->assertEquals([
            'password',
            'remember_token',
        ], $this->user->getHidden());
    }

    public function test_user_contains_valid_casts_properties()
    {
        $this->assertEquals([
            'id' => 'int',
            'email_verified_at' => 'datetime',
        ], $this->user->getCasts());
    }

    public function test_role_relationship()
    {
        $role =  $this->user->role();
        $this->assertInstanceOf(BelongsTo::class, $role);
        $this->assertEquals('role_id', $role->getForeignKeyName());
        $this->assertEquals('id', $role->getOwnerKeyName());
    }

    public function test_posts_relationship()
    {
        $post = $this->user->posts();
        $this->assertInstanceOf(BelongsToMany::class, $post);
        $this->assertEquals('user_id', $post->getForeignPivotKeyName());
        $this->assertEquals('post_id', $post->getRelatedPivotKeyName());
    }

    public function test_comments_relationship()
    {
        $comment = $this->user->comments();
        $this->assertInstanceOf(HasMany::class, $comment);
        $this->assertEquals('user_id', $comment->getForeignKeyName());
        $this->assertEquals('id', $comment->getLocalKeyName());
    }
    
    public function test_following_relationship()
    {
        $following = $this->user->following();
        $this->assertInstanceOf(BelongsToMany::class, $following);
        $this->assertEquals('user_id', $following->getForeignPivotKeyName());
        $this->assertEquals('follow_id', $following->getRelatedPivotKeyName());
    }

    public function test_follower_relationship()
    {
        $follower = $this->user->follower();
        $this->assertInstanceOf(BelongsToMany::class, $follower);
        $this->assertEquals('follow_id', $follower->getForeignPivotKeyName());
        $this->assertEquals('user_id', $follower->getRelatedPivotKeyName());
    }

    public function test_activities_relationship()
    {
        $activities = $this->user->activities();
        $this->assertInstanceOf(HasMany::class, $activities);
        $this->assertEquals('user_id', $activities->getForeignKeyName());
        $this->assertEquals('id', $activities->getLocalKeyName());
    }

    public function test_follows_relationship()
    {
        $follow = $this->user->follows();
        $this->assertInstanceOf(HasMany::class, $follow);
        $this->assertEquals('user_id', $follow->getForeignKeyName());
        $this->assertEquals('id', $follow->getLocalKeyName());
    }
}
