<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository extends Repository
{
    /**
     * @var Customer
     */
    protected $model = Customer::class;

    public function findByPhone($phone)
    {
        return $this->model()->findByField('phone', $phone);
    }
}
