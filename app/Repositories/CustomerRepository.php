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

    /**
     * @param array $customer
     * @param null $id
     * @return string
     */
    public function create(array $attributes, $userId)
    {
        try {
            DB::beginTransaction();
            $customer = $this->customerModel::where('user_id', $userId)->first();

            $customer->update([
                'first_name' => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                'dob' => $attributes['dob'],
                'gender' => $attributes['gender']
            ]);

            $contactDetails = [
                'customer_id' => (int) $customer->id,
                'phone' => $attributes['phone'],
                'address_1' => $attributes['address_1'],
                'address_2' => $attributes['address_2'],
                'address_3' => $attributes['address_3'],
                'city' => $attributes['city'],
                'county' => $attributes['county'],
                'post_code' => $attributes['post_code'],
                'country' => $attributes['country']
            ];

            DB::table('customer_contact_details')->insert($contactDetails);

            DB::commit();

            return $customer;

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * @param array $customer
     * @param $customerId
     * @return string
     */
    public function update(array $attributes, $customerId)
    {
        try {
            DB::beginTransaction();
            $customer = $this->customerModel::find($customerId);

            $customer->update([
                'first_name' => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                'dob' => $attributes['dob'],
                'gender' => $attributes['gender']
            ]);

            $contactDetails = [
                'customer_id' => (int) $customer->id,
                'phone' => $attributes['phone'],
                'address_1' => $attributes['address_1'],
                'address_2' => $attributes['address_2'],
                'address_3' => $attributes['address_3'],
                'city' => $attributes['city'],
                'county' => $attributes['county'],
                'post_code' => $attributes['post_code'],
                'country' => $attributes['country']
            ];

            DB::table('customer_contact_details')
                ->updateOrInsert(
                    ['customer_id' => $customer->id],
                    $contactDetails
                );

            DB::commit();

            return $customer;

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function softDelete(int $id)
    {

    }

    public function hardDelete()
    {

    }
}