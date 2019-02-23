<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements RepositoryInterface
{
    private $user;

    public function __construct(User $user)
    {
       $this->user = $user;
    }

    public function all()
    {

    }

    public function find($userId)
    {

    }

    public function create(array $attributes)
    {
        try {
            DB::beginTransaction();
            $user = $this->user::create([
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => Hash::make($attributes['password']),
            ]);

            DB::table('applicants')->insert(['user_id' => $user->id]);
            DB::commit();

            return $user;
        } catch (\PDOException $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function update(array $attributes, $userId)
    {

    }

    public function softDelete(int $userId)
    {

    }

    public function hardDelete()
    {

    }
}