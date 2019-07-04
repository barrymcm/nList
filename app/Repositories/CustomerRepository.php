<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements RepositoryInterface
{
    private $customerModel;
    private $userModel;

    public function __construct(Customer $customer, User $user)
    {
       $this->customerModel = $customer;
       $this->userModel = $user;
    }

    public function all()
    {

    }

    public function find($id)
    {
        try {
            return $this->customerModel::find($id);

        } catch (ModelNotFoundException $e) {
            logger($e->getMessage());

            return false;
        }
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
        $userId = $this->customerModel::find($id)->user_id;

        try {
            DB::beginTransaction();
            $this->customerModel::destroy($id) && $this->userModel::destroy($userId);
            DB::commit();

            return true;
        } catch (\PDOException $e) {
            DB::rollBack();
            logger($e->getMessage());
            /**
             * @todo what is the best way to notify a user if they failed to delete their account.
             */
        }
    }

    public function hardDelete()
    {

    }
}