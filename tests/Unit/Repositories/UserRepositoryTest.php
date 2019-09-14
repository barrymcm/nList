<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserRepositoryTest extends TestCase
{
    private $userRepository;
    private $mockedUser;

    public function setUp()
    {
        $this->mockedUser = \Mockery::mock('App\Models\User');
        $this->userRepository = new UserRepository($this->mockedUser);
    }

    /**
     * @expectedException \PDOException
     * @runTestsInSeparateProcesses
     * @preserveGlobalState disabled
     */
    public function testCreateThrowsException()
    {
        $attributes = [
            'name' => 'mocked_name',
            'email' => 'mocked_email',
            'password' => 'mocked_password',
        ];

        DB::shouldReceive('beginTransaction')
            ->set('query', 'query test')
            ->andReturn(true);

        Hash::shouldReceive('make')
            ->once()
            ->with($attributes['password'])
            ->andReturn(true);

        $this->mockedUser
            ->shouldReceive('create')
            ->with($attributes, null)
            ->andReturn(false);

        $this->userRepository->create($attributes);
    }

    protected function createMockedUser()
    {
        return \Mockery::mock('alias:App\Models\User');
    }
}
