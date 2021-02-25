<?php

namespace Tests\Unit\Notification;

use Tests\TestCase;
use App\Notifications\CommentNotification;

class CommentNotificationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $commentNoti, $data;

    public function setUp() : void
    {
        parent::setUp();
        $this->data = [
            'usernameOfUser' => 'kien123',
            'user_name' => 'xuannguyen',
            'action' => 'mes.like',
            'for_you' => 'mes.your_post',
        ];
        $this->commentNoti = new CommentNotification($this->data);
    }

    public function tearDown() : void
    {
        unset($this->commentNoti);
        parent::tearDown();
    }

    public function test_via_database()
    {
        $this->assertEquals(['database'], $this->commentNoti->via($this->data));
    }

    public function test_to_database()
    {
        $this->assertEquals($this->data, $this->commentNoti->toDatabase($this->data));
    }
}
