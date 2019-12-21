<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository implements RepositoryInterface
{
    private $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function all()
    {
    }

    public function find($id)
    {
    }

    public function findById($userId)
    {
        try {
            $user = $this->userModel::where('id', $userId)->first();

            return $user;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function create(array $attributes, $id = null)
    {
        try {
            DB::beginTransaction();
            $user = $this->userModel::create([
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => Hash::make($attributes['password']),
            ]);

            $roleId = $this->getRoleId($attributes['type']);

            if ($attributes['type'] == 'customer') {
                DB::table('customers')->insert(['user_id' => $user->id]);
                DB::table('user_role')->insert(
                    [
                        'user_id' => $user->id,
                        'role_id' => $roleId,
                        'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', now()),
                    ]
                );
            }

            if ($attributes['type'] == 'organiser') {

                DB::table('event_organisers')->insert(['user_id' => $user->id, 'name' => $user->name]);
                DB::table('user_role')->insert([
                    'user_id' => $user->id,
                    'role_id' => $roleId,
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', now()),
                ]);
            }

            DB::commit();

            return $user;
        } catch (\PDOException $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            return $e->getMessage();
        }
    }

    private function getRoleId($userType)
    {
        try {
            return DB::table('roles')->where('name', $userType)->value('id');    
        } catch (\PDOException $e) {
            Log::error($e->getMessage());
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
