<?php

namespace Tests\Unit\Jobs;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Jobs\SendOtpMailJob;

class SendOtpMailJobTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $data, $job;

    public function setUp() : void
    {
        parent::setUp();
        $this->data = [
            'otp' => '123456',
            'email' => 'kien@gmail.com',
        ];
        $this->job = new SendOtpMailJob($this->data);
    }

    public function tearDown() : void
    {
        unset($this->job);
        unset($this->data);
        parent::tearDown();
    }

    public function test_handle_function()
    {
        Mail::fake();
        $this->job->handle();
        Mail::assertSent(SendOtpMail::class, function ($mail) {
             $mail->hasTo($this->data['email']);
             return true;
        });
    }
}
