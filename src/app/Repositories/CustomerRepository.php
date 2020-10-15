<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function find(int $id): ?Customer
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
    public function create(array $attributes, int $userId)
    {
        try {
            DB::beginTransaction();
            $customer = $this->customerModel::where('user_id', $userId)->first();
            $user = $this->userModel::where('id', $customer->user_id)->first();

            $customer->update([
                'first_name' => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                'dob' => $attributes['dob'],
                'gender' => $attributes['gender'],
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', now())
            ]);

            $contactDetails = [
                'customer_id' => (int) $customer->id,
                'email' => $user->email,
                'phone' => $attributes['phone'],
                'address_1' => $attributes['address_1'],
                'address_2' => $attributes['address_2'],
                'address_3' => $attributes['address_3'] ?? '',
                'city' => $attributes['city'],
                'county' => $attributes['county'],
                'post_code' => $attributes['post_code'],
                'country' => $attributes['country'],
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
    public function update(array $attributes, int $customerId)
    {
        try {
            DB::beginTransaction();
            $customer = $this->customerModel::find($customerId);
            $user = $this->userModel::find($customer->user_id);

            $customer->update([
                'first_name' => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                'dob' => $attributes['dob'],
                'gender' => $attributes['gender'],
            ]);

            $contactDetails = [
                'customer_id' => (int) $customer->id,
                'email' => $user->email,
                'phone' => $attributes['phone'],
                'address_1' => $attributes['address_1'],
                'address_2' => $attributes['address_2'],
                'address_3' => $attributes['address_3'] ?? '',
                'city' => $attributes['city'],
                'county' => $attributes['county'],
                'post_code' => $attributes['post_code'],
                'country' => $attributes['country'],
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
