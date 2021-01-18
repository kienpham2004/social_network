<?php

namespace Tests\Unit\Http\Controller;

use Tests\TestCase;
use Mockery;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Repositories\Profile\ProfileRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Like\LikeRepositoryInterface;

class HomeControllerTest extends TestCase
{
    protected $profileMock, $postMock, $likeMock, $homeController;

    public function setUp() : void
    {
        parent::setUp();
        $this->profileMock = Mockery::mock(ProfileRepositoryInterface::class)->makePartial();
        $this->postMock = Mockery::mock(PostRepositoryInterface::class)->makePartial();
        $this->likeMock = Mockery::mock(LikeRepositoryInterface::class)->makePartial();
        $this->homeController = new HomeController($this->profileMock, $this->postMock, $this->likeMock);
    }

    public function tearDown() : void
    {
        Mockery::close();
        unset($this->homeController);
        parent::tearDown();
    }

    public function test_index_method()
    {
        $this->profileMock->shouldReceive('getIdFollowingPluckId')->andReturn(true);
        $this->profileMock->shouldReceive('getListSuggess')->with('dabhsdbh')->andReturn(true);
        $this->postMock->shouldReceive('getPostLimit')->with('dhasjd')->andReturn(true);
        $this->likeMock->shouldReceive('selectLikePostId')->andReturn(true);
        $this->likeMock->shouldReceive('convertArrLike')->with('jhabshd')->andReturn(true);
        $result = $this->homeController->index();
        $this->assertEquals('time_line', $result->getName());
        $this->assertArrayHasKey('posts', $result->getData());
        $this->assertArrayHasKey('suggessForYou', $result->getData());
        $this->assertArrayHasKey('likeArr', $result->getData());
    }

    public function test_loadpost_method()
    {
        $id = 1;
        $request = new Request();
        $this->profileMock->shouldReceive('getIdFollowingPluckId')->andReturn(true);
        $this->postMock->shouldReceive('getPostLoadMore')->with('djasnd', $request->id)->andReturn(true);
        $this->likeMock->shouldReceive('selectLikePostId')->andReturn(true);
        $this->likeMock->shouldReceive('convertArrLike')->with('jhabshd')->andReturn(true);
        $result = $this->homeController->loadPost($request);
        $this->assertEquals('layouts.load-post', $result->getName());
        $this->assertArrayHasKey('posts', $result->getData());
        $this->assertArrayHasKey('likeArr', $result->getData());
    }

    public function test_viewcomment_method()
    {
        $id = 2;
        $request = new Request();
        $this->profileMock->shouldReceive('getIdFollowingPluckId')->andReturn(true);
        $this->postMock->shouldReceive('getPostLoadMore')->with('djasnd', $request->id)->andReturn(true);
        $this->likeMock->shouldReceive('selectLikePostId')->andReturn(true);
        $this->likeMock->shouldReceive('convertArrLike')->with('jhabshd')->andReturn(true);
        $result = $this->homeController->viewComment($request);
        $this->assertEquals('layouts.load-comment', $result->getName());
        $this->assertArrayHasKey('posts', $result->getData());
        $this->assertArrayHasKey('likeArr', $result->getData());
    }
}
