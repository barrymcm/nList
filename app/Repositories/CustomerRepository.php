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
        return $this->customerModel::find($id);
    }

    public function create(array $customer, $id = null)
    {

        try {
            DB::beginTransaction();
            $customerModel = $this->customerModel::create($customer);

            $customerContactDetails = [
                'customer_id' => $customerModel->id,
                'phone' => $customer['phone'],
                'address_1' => $customer['address_1'],
                'address_2' => $customer['address_2'],
                'address_3' => $customer['address_3'],
                'city' => $customer['city'],
                'county' => $customer['county'],
                'post_code' => $customer['post_code'],
                'country' => $customer['country']
            ];

            DB::table('customer_contact_details')
                ->insert($customerContactDetails);

            DB::commit();

            return $customerModel;

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return $e->getMessage();
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