<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerRepository implements RepositoryInterface
{
    private $customer;

    public function __construct(Customer $customer)
    {
       $this->customer = $customer;
    }

    public function all()
    {

    }

    public function find($id)
    {

    }

    public function create(array $customer, $id)
    {

    }

    public function update(array $customer, $id)
    {

    }

    public function softDelete(int $id)
    {

    }

    public function hardDelete()
    {

    }
}