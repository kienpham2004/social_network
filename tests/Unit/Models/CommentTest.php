<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CommentTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $comment;

    public function setUp() : void 
    {
        $this->comment = new Comment();
        parent::setUp();
    }

    public function tearDown() : void 
    {
        $this->comment = null;
        parent::tearDown();
    }

    public function test_comment_contains_valid_fillable_properties()
    {
        $this->assertEquals([
            'user_id',
            'post_id',
            'content',
        ], $this->comment->getFillable());
    }

    public function test_user_relationship()
    {
        $user = $this->comment->user();
        $this->assertInstanceOf(BelongsTo::class, $user);
        $this->assertEquals('user_id', $user->getForeignKeyName());
        $this->assertEquals('id', $user->getOwnerKeyName());
    }

    public function test_posts_relationship()
    {
        $post = $this->comment->post();
        $this->assertInstanceOf(BelongsTo::class, $post);
        $this->assertEquals('post_id', $post->getForeignKeyName());
        $this->assertEquals('id', $post->getOwnerKeyName());
    }

    public function test_activities_relationship()
    {
        $actable = $this->comment->activities();
        $this->assertInstanceOf(MorphMany::class, $actable);
        $this->assertEquals('actable_id', $actable->getForeignKeyName());
        $this->assertEquals('actable_type', $actable->getMorphType());
    }
}
