<?php

namespace Tests\Unit\Commands;

use Tests\TestCase;
use App\Console\Commands\StoryCommand;
use App\Jobs\DeleteStoryJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Testing\Fakes\BusFake;

class StoryCommandTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $storyCommand;
    
    public function setUp() : void
    {
        parent::setUp();
        $this->storyCommand = new StoryCommand();
    }

    public function tearDown() : void
    {
        unset($this->storyCommand);
        parent::tearDown();
    }

    public function test_valid_signature_property()
    {
        $this->assertEquals('delete:story', $this->storyCommand->getName());
    }

    public function test_valid_description_property()
    {
        $this->assertEquals('Detele story after 24h', $this->storyCommand->getDescription());
    }

    public function test_method_handle()
    {
        Bus::fake();
        $this->storyCommand->handle();
        Bus::assertDispatched(DeleteStoryJob::class);
    }
}
