<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    protected function generateCode()
    {
        $prefix = 'PHLCS';
        $lastCustomer = $this->customer->where('code', 'like', $prefix.'%')->orderBy('code', 'desc')->first();
        $lastSequence = 0;
        if (! empty($lastCustomer)) {
            $lastSequence = substr($lastCustomer->code, -4);
        }
        $nextSequence = $lastSequence + 1;
        $nextSequence = sprintf('%04d', $nextSequence);
        $code = $prefix.$nextSequence;

        return $code;
    }

    public function findOrCreate($customer)
    {
        if (is_numeric($customer['name'])) {
            $customer = $this->customer->findOrFail($customer['name']);
            $customer->update([
                'phone_number' => $customer['phone_number'],
                'delivery_address' => $customer['delivery_address'],
            ]);

            return $customer->id;
        }

        $customer = $this->customer->create([
            'code' => $this->generateCode(),
            'name' => $customer['name'],
            'phone_number' => $customer['phone_number'],
            'delivery_address' => $customer['delivery_address'],
        ]);

        return $customer->id;
    }
}
