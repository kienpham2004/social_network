<?php

namespace Tests\Unit\Http\Controller;

use Tests\TestCase;
use Mockery;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Follow;
use App\Http\Controllers\FollowController;
use App\Repositories\Follow\FollowRepositoryInterface;
use App\Repositories\Activity\ActivityRepositoryInterface;
use Illuminate\Http\JsonResponse;

class FollowControllerTest extends TestCase
{
    protected $followMock, $followController, $activityMock;

    public function setUp() : void
    {
        parent::setUp();
        $this->followMock = Mockery::mock(FollowRepositoryInterface::class)->makePartial();
        $this->activityMock = Mockery::mock(ActivityRepositoryInterface::class)->makePartial();
        $this->followController = new FollowController($this->followMock, $this->activityMock);
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
        $data_create = [
            'user_id' => config('id.id_user_login_current'),
            'follow_id' => config('id, id_user_has_been_follow'),
        ];
        $dataNoti = [
            'message' => 'profile.action_follow_history',
            'user_name' => 'hathu99',
        ];
        $dataActivity = [
            'user_id' => $user->id,
            'action' => 2,
            'notify' => json_encode($dataNoti),
        ];
        $this->followMock->shouldReceive('getFollower')->with($request->id)->andReturn(true);
        $this->followMock->shouldReceive('getUserRelationFriend')->with($request->id)->andReturn(true);
        $this->followMock->shouldReceive('create')->with($data_create)->andReturn($follow);
        $this->activityMock->shouldReceive('create')->withAnyArgs($dataActivity)->andReturn(true).
        $this->activityMock->shouldReceive('saveDataToActivity')->withAnyArgs($data, $dataActivity)->andReturn(true);
        $controller = $this->followController->follow($request);

        $result = [
            'user_id' => $user->id,
            'follow_id' => $follow->id,
        ];
        $this->assertEquals($result, $controller->original);
    }

    public function test_follow_fails_by_getUserRelationFriend_fails()
    {
        $user = factory(User::class)->make();
        $user->id = config('id.id_user_login_current');
        $follow = factory(Follow::class)->make();
        $follow->id = config('id.id_user_has_been_follow');
        $this->be($user);
        $request = new Request;
        $data = [
            'user_id' => $user->id,
            'follow_id' => $follow->id,
        ];
        $data_create = [
            'user_id' => config('id.id_user_login_current'),
            'follow_id' => config('id, id_user_has_been_follow'),
        ];
        $dataNoti = [
            'message' => 'profile.action_follow_history',
            'user_name' => 'hathu99',
        ];
        $dataActivity = [
            'user_id' => config('id.id_user_login_current'),
            'action' => config('create_data.follow'),
            'notify' => json_encode($dataNoti),
        ];
        $this->followMock->shouldReceive('getFollower')->with($request->id)->andReturn(true);
        $this->followMock->shouldReceive('getUserRelationFriend')->with($request->id)->andReturn(true);
        $this->followMock->shouldReceive('create')->with($data_create)->andReturn($follow);
        $this->activityMock->shouldReceive('create')->withAnyArgs($dataActivity)->andReturn([]).
        $this->activityMock->shouldReceive('saveDataToActivity')->withAnyArgs($data, $dataActivity)->andReturn(true);
        $controller = $this->followController->follow($request);
        $this->assertEquals($data, $controller->original);
    }

    public function test_follow_fail_by_create()
    {
        $user = factory(User::class)->make();
        $user->id = config('id.id_user_login_current');
        $follow = factory(Follow::class)->make();
        $follow->id = config('id.id_user_has_been_follow');;
        $this->be($user);
        $request = new Request;
        $data = [
            'status' => config('id.status_fail_404'),
            'message' => trans('mes.fail'),
        ];
        $dataNoti = [
            'message' => 'profile.action_follow_history',
            'user_name' => 'hathu99',
        ];
        $data_create = [
            'user_id' => config('id.id_user_login_current'),
            'follow_id' => config('id, id_user_has_been_follow'),
        ];
        $dataActivity = [
            'user_id' => $user->id,
            'action' => 2,
            'notify' => json_encode($dataNoti),
        ];
        $this->followMock->shouldReceive('getFollower')->with($request->id)->andReturn(true);
        $this->followMock->shouldReceive('getUserRelationFriend')->with($request->id)->andReturn(true);
        $this->followMock->shouldReceive('create')->with($data_create)->andReturn(false);
        $controller = $this->followController->follow($request);

        $this->assertEquals($data, $controller->original);
    }

    public function test_follow_fail()
    {
        $user = factory(User::class)->make();
        $user->id = config('id.id_user_login_current');
        $follow = factory(Follow::class)->make();
        $follow->id = config('id.id_user_has_been_follow');
        $this->be($user);
        $request = new Request;
        $data_create = [
            'user_id' => config('id.id_user_login_current'),
            'follow_id' => config('id, id_user_has_been_follow'),
        ];
        $this->followMock->shouldReceive('create')->with($data_create)->andReturn(false);
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
        $this->followMock->shouldReceive('findIdUser')->with($follow->id)->andReturn(true);
        $this->followMock->shouldReceive('delete')->with($user->id)->andReturn(true);
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
        $this->followMock->shouldReceive('findIdUser')->with($follow->id)->andReturn(false);
        $controller = $this->followController->unfollow($follow->id);
        $result = [
            'status' => config('id.status_fail_404'),
            'message' => trans('mes.fail'),
        ];
        $this->assertEquals($result, $controller->original);
    }
}
