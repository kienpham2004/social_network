<?php

namespace Tests\Unit\Notification;

use Tests\TestCase;
use App\Notifications\LikeNotication;

class LikeNotificationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $likeNoti, $data;

    public function setUp() : void
    {
        parent::setUp();
        $this->data = [
            'usernameOfUser' => 'kien123',
            'user_name' => 'xuannguyen',
            'action' => 'mes.like',
            'for_you' => 'mes.your_post',
        ];
        $this->likeNoti = new LikeNotication($this->data);
    }

    public function tearDown() : void
    {
        unset($this->likeNoti);
        parent::tearDown();
    }

    public function test_via_database()
    {
        $this->assertEquals(['database'], $this->likeNoti->via($this->data));
    }

    public function test_to_database()
    {
        $this->assertEquals($this->data, $this->likeNoti->toDatabase($this->data));
    }
}
