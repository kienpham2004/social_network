<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LikeTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $like;

    public function setUp() : void 
    {
        $this->like = new Like();
        parent::setUp();
    }

    public function tearDown() : void 
    {
        $this->like = null;
        parent::tearDown();
    }

    public function test_activities_contains_valid_fillable_properties()
    {
        $this->assertEquals([
            'user_id',
            'post_id',
        ], $this->like->getFillable());
    }

    public function test_activities_relationship()
    {
        $actable = $this->like->activities();
        $this->assertInstanceOf(MorphMany::class, $actable);
        $this->assertEquals('actable_id', $actable->getForeignKeyName());
        $this->assertEquals('actable_type', $actable->getMorphType());
    }

    public function test_user_relationship()
    {
        $user = $this->like->user();
        $this->assertInstanceOf(BelongsTo::class, $user);
        $this->assertEquals('user_id', $user->getForeignKeyName());
        $this->assertEquals('id', $user->getOwnerKeyName());
    }

    public function test_posts_relationship()
    {
        $post = $this->like->post();
        $this->assertInstanceOf(BelongsTo::class, $post);
        $this->assertEquals('post_id', $post->getForeignKeyName());
        $this->assertEquals('id', $post->getOwnerKeyName());
    }
}
