<?php

namespace Tests\Unit\Http\Controller;

use Tests\TestCase;
use Mockery;
use App\Models\User;
use App\Http\Controllers\TimeLineController;
use App\Repositories\Activity\ActivityRepositoryInterface;
use App\Repositories\Profile\ProfileRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Follow\FollowRepositoryInterface;

class TimeLineControllerTest extends TestCase
{
    protected $profileMock, $postMock, $followMock, $timelineController, $activityMock;

    public function setUp() : void
    {
        parent::setUp();
        $this->profileMock = Mockery::mock(ProfileRepositoryInterface::class)->makePartial();
        $this->postMock = Mockery::mock(PostRepositoryInterface::class)->makePartial();
        $this->followMock = Mockery::mock(FollowRepositoryInterface::class)->makePartial();
        $this->activityMock = Mockery::mock(ActivityRepositoryInterface::class)->makePartial();
        $this->timelineController = new TimeLineController($this->profileMock, $this->postMock, $this->followMock, $this->activityMock);
    }

    public function tearDown() : void
    {
        Mockery::close();
        unset($this->timelineController);
        parent::tearDown();
    }

    public function test_search_exists_viewuser()
    {
        $counts = [];
        $user = factory(User::class)->make();
        array_push($counts, $user);
        $this->be($user);
        $this->profileMock->shouldReceive('getUserByUsername')->with($user->username)->andReturn($counts);
        $this->postMock->shouldReceive('getPostWithUserImageCommentLatest')->with('user_id', $user->id)->andReturn(true);
        $this->followMock->shouldReceive('checkFollow')->with($user->id, $user->id)->andReturn(true);
        $this->activityMock->shouldReceive('getActivity')->andReturn(true);
        $result = $this->timelineController->viewUser($user->username);
        $this->assertEquals('view_user', $result->getName());
        $this->assertArrayHasKey('counts', $result->getData());
        $this->assertArrayHasKey('posts', $result->getData());
        $this->assertArrayHasKey('checkFollow', $result->getData());
        $this->assertArrayHasKey('listHistory', $result->getData());
    }

    public function test_search_not_exists_viewuser()
    {
        $username = "kien";
        $this->profileMock->shouldReceive('getUserByUsername')->once()->with($username)->andReturn(false);
        $result = $this->timelineController->viewUser($username);
        $this->assertEquals(route('home'), $result->getTargetUrl());
    }
}
