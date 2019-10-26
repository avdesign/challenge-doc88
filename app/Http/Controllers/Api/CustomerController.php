<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Traits\OnlyTrashed;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CustomerRequest;
use App\Http\Resources\Api\CustomersResource;

use Illuminate\Http\Request;


class CustomersController extends Controller
{
    use OnlyTrashed;

    private $perPage=5;

    /**
     * Lista os Clientes do sistema.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Consultar a query com o lixo quando for requisitado.
        $query = Customer::query();
        $query = $this->onlyTrashedIfRequested($request, $query);
        $customers = $query->paginate($this->perPage);

        return CustomersResource::collection($customers);
    }


    /**
     * Criar cliente com um código unico.
     *
     * @param  \App\Http\Requests\Api\CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $dataJson = $request->all();
        // Código unico do cliente
        $code = uniqid(date('YmdHis'));
        $dataJson['code'] = returnNumber($code);

        $customer = Customer::create($dataJson);
        return new CustomersResource($customer);
    }

    /**
     * Retorna o cliente especifico
     *    *
     * @param Customer $customer
     * @return CustomersResource
     */
    public function show(Customer $customer)
    {
        return new CustomersResource($customer);
    }


    /**
     * Método fill vai hidratar somente os dados seguros da variável $fillable do model
     *
     * @param CustomerRequest $request
     * @param Customer $customer
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->fill($request->all());
        $customer->save();
    }

    /**
     * Remove the Customer.
     *
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json([], 204);
    }


    /**
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Customer $customer)
    {
        $customer->restore();

        return new ProductResource($customer);
    }



}
