<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $role;

    protected function setUp(): void
    {
        $this->role = new Role();
        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->role = null;
        parent::tearDown();
    }

    public function test_role_contains_valid_fillable_properties()
    {
        $this->assertEquals([
            'name',
        ], $this->role->getFillable());
    }

    public function test_users_relationship()
    {
        $user = $this->role->users();
        $this->assertInstanceOf(HasMany::class, $user);
        $this->assertEquals('role_id', $user->getForeignKeyName());
        $this->assertEquals('id', $user->getLocalKeyName());
    }
}
