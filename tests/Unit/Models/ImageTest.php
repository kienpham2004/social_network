<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $image;

    public function setUp() : void 
    {
        $this->image = new Image();
        parent::setUp();
    }

    public function tearDown() : void 
    {
        $this->image = null;
        parent::tearDown();
    }

    public function test_comment_contains_valid_fillable_properties()
    {
        $this->assertEquals([
            'photo_url',
            'photo_alt',
            'post_id',
        ], $this->image->getFillable());
    }

    public function test_post_relationship()
    {
        $post =  $this->image->posts();
        $this->assertInstanceOf(BelongsTo::class, $post);
        $this->assertEquals('posts_id', $post->getForeignKeyName());
        $this->assertEquals('id', $post->getOwnerKeyName());
    }
}
