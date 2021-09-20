<?php

namespace App\Services;

use App\Repositories\CustomerRepository;

class CustomerService extends Service
{
    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * QueryService constructor.
     *
     * @param CustomerRepository $customerRepository
     */
    public function __construct(
        CustomerRepository $customerRepository
    ){
        $this->customerRepository = $customerRepository;
    }

    public function findByPhone($phone)
    {
        return $this->customerRepository->findByPhone($phone);
    }
}
