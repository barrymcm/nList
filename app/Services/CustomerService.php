<?php

namespace App\Services;

use App\Repositories\CustomerRepository;

class CustomerService
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * CustomerService constructor.
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param $customerId
     * @return bool
     */
    public function hasCustomerProfile($customer) : bool
    {
        if ( is_object($customer)
            && isset($customer->first_name)
            && isset($customer->last_name)
            && isset($customer->dob)
            && isset($customer->gender)
        ) {
            return true;
        }

        return false;

    }
}