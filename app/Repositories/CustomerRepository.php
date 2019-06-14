<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements RepositoryInterface
{
    private $customerModel;

    public function __construct(Customer $customer)
    {
       $this->customerModel = $customer;
    }

    public function all()
    {

    }

    public function find($id)
    {

    }

    public function create(array $customer, $id)
    {
        try {
            DB::beginTransaction();
            $customer = $this->customerModel::create($customer);

            DB::table('customers')
                ->insert([
                    ''
                ]);


        } catch (ModelNotFoundException $e) {

        }
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