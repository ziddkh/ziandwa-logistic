<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;

class CustomerService
{
    protected $customerRepository;

    protected $customer;

    public function __construct(CustomerRepository $customerRepository, Customer $customer)
    {
        $this->customerRepository = $customerRepository;
        $this->customer = $customer;
    }

    public function createCustomer($request)
    {
        $customer = $this->customerRepository->findOrCreate([
            'name' => $request['name'],
            'phone_number' => $request['phone_number'],
            'delivery_address' => $request['delivery_address'],
        ]);

        return $customer;
    }
}
