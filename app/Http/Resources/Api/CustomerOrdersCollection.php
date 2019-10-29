<?php

namespace App\Http\Resources\Api;

use App\Models\Customer;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerOrdersCollection extends ResourceCollection
{
    /**
     * @var customer
     */
    private $customer;

    public function __construct($resource, Customer $customer)
    {
        parent::__construct($resource);
        $this->customer = $customer;
    }

    /**
     * Retorna todos os pedidos referente ao produto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'cliente' => new CustomerResource($this->customer),
            'pedidos' => $this->collection->map(function($order){
                return new OrderResource($order, 'customer');
            })
        ];
    }
}
