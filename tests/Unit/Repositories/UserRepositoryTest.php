<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private $userRepository;
    private $mockedUser;

    public function setUp()
    {
        $this->mockedUser = app()->instance('App\Models\User', $this->createMockedUser());
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
            'password' => 'mocked_password'
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

        $this->expectException(\PDOException::class);
        $this->userRepository->create($attributes);
    }

    protected function createMockedUser()
    {
        return \Mockery::mock('alias:App\Models\User');
    }
}
