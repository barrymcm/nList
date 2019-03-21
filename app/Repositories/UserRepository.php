<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
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

    public function create(array $attributes, $id = null)
    {
        try {
            DB::beginTransaction();
            $user = $this->user::create([
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => Hash::make($attributes['password']),
            ]);

            $roleId = $this->getRoleId($attributes['type']);

            if ($attributes['type'] == 'applicant') {
                DB::table('applicants')->insert(['user_id' => $user->id]);
                DB::table('user_role')->insert([
                        'user_id' => $user->id,
                        'role_id' => $roleId,
                        'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', now())
                    ]
                );
            }

            if ($attributes['type'] == 'organiser') {
                DB::table('user_role')->insert(['user_id' => $user->id, 'role_id' => $roleId]);
            }
                DB::commit();

            return $user;
        } catch (\PDOException $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    private function getRoleId($userType) : int
    {
        return DB::table('roles')
            ->where('name', $userType)
            ->value('id');
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