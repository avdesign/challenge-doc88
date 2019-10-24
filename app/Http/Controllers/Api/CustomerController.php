<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CustomerRequest;
use App\Http\Resources\Api\CustomersResource;



class CustomersController extends Controller
{
    private $perPage=5;

    /**
     * Lista os usuários do sistema.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::paginate($this->perPage);

        return CustomersResource::collection($customers);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $customer = Customer::createCustomer($request->all());
        return new CustomersResource($customer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return new CustomersResource($customer);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\CustomerRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
