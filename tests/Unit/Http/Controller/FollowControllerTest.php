<?php

namespace Tests\Unit\Http\Controller;

use Tests\TestCase;
use Mockery;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Follow;
use App\Http\Controllers\FollowController;
use App\Repositories\Follow\FollowRepositoryInterface;
use Illuminate\Http\JsonResponse;

class FollowControllerTest extends TestCase
{
    protected $followMock, $followController, $profileMock;

    public function setUp() : void
    {
        parent::setUp();
        $this->profileMock = Mockery::mock(ProfileRepositoryInterface::class)->makePartial();
        $this->followMock = Mockery::mock(FollowRepositoryInterface::class)->makePartial();
        $this->followController = new FollowController($this->followMock);
    }

    public function tearDown() : void
    {
        Mockery::close();
        unset($this->followController);
        parent::tearDown();
    }

    public function test_follow_success()
    {
        $user = factory(User::class)->make();
        $user->id = config('id.id_user_login_current');
        $follow = factory(Follow::class)->make();
        $follow->id = config('id.id_user_has_been_follow');;
        $this->be($user);
        $request = new Request;
        $data = [
            'user_id' => $user->id,
            'follow_id' => $request->id,
        ];
        
        $this->followMock->shouldReceive('create')->withAnyArgs($data)->andReturn($follow);
        $controller = $this->followController->follow($request);
        $result = [
            'user_id' => $user->id,
            'follow_id' => $follow->id,
        ];
        $this->assertEquals($result, $controller->original);
    }

    public function test_follow_fail()
    {
        $user = factory(User::class)->make();
        $user->id = config('id.id_user_login_current');
        $follow = factory(Follow::class)->make();
        $follow->id = config('id.id_user_has_been_follow');
        $this->be($user);
        $request = new Request;
        $data = [
            'user_id' => $user->id,
            'follow_id' =>  $follow->id ,
        ];
        
        $this->followMock->shouldReceive('create')->withAnyArgs($data)->andReturn(false);
        $controller = $this->followController->follow($request);
        $result = [
            'status' => config('id.status_fail_404'),
            'message' => trans('mes.fail'),
        ];
        $this->assertEquals($result, $controller->original);
    }

    public function test_unfollow_success()
    {
        $user = factory(User::class)->make();
        $user->id = config('id.id_user_login_current');
        $follow = factory(Follow::class)->make();
        $follow->id = config('id.id_user_has_been_follow');
        $this->followMock->shouldReceive('findIdUser')->withAnyArgs($follow->id)->andReturn(true);
        $this->followMock->shouldReceive('delete')->withAnyArgs($user->id)->andReturn(true);
        $controller = $this->followController->unfollow($follow->id);
        $data = [
            'follow_id' => $follow->id,
        ];
        $this->assertEquals($data, $controller->original);
    }

    public function test_unfollow_fail()
    {
        $user = factory(User::class)->make();
        $user->id = config('id.id_user_login_current');
        $follow = factory(Follow::class)->make();
        $follow->id = config('id.id_user_has_been_follow');
        $this->followMock->shouldReceive('findIdUser')->withAnyArgs($follow->id)->andReturn(false);
        $controller = $this->followController->unfollow($follow->id);
        $result = [
            'status' => config('id.status_fail_404'),
            'message' => trans('mes.fail'),
        ];
        $this->assertEquals($result, $controller->original);
    }
}
