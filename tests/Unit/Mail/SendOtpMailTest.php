<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;

class SendOtpMailTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $data, $sendOtp;

    public function setUp() : void
    {
        parent::setUp();
        $this->sendOtpMail = new SendOtpMail($this->data);
    }

    public function tearDown() : void
    {
        unset($this->sendOtpMail);
        parent::tearDown();
    }

    public function test_build_function_send_mail_sussess()
    {
        Mail::fake();
        Mail::send($this->sendOtpMail);
        Mail::assertSent(SendOtpMail::class, function($mail) {
            $this->sendOtpMail->build();

            return true;
        });
    }

    public function test_build_function_send_mail_fail()
    {
        Mail::fake();
        Mail::send($this->sendOtpMail);
        Mail::assertNotSent(SendOtpMail::class, function($mail) {
            $this->sendOtpMail->build();
            
            return false;
        });
    }
}
