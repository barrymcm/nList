<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Customer $customer)
    {
        return $customer->user->is($user);
    }

    public function update(User $user, Customer $customer)
    {
        return $customer->user->is($user);
    }

    public function delete(User $user, Customer $customer)
    {
        return $customer->user->is($user);
    }
}