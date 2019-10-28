<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrderResource;
use App\Interfaces\OrderInterface as InterModel;


class OrderController extends Controller
{
    private $perPage=5;
    private $interModel;
    private $messages;


    public function __construct(InterModel $interModel)
    {
        $this->interModel = $interModel;
        // Este tipo de validação pode ser gerado de um bd.
        $this->messages = array(
            'amount.required'  => 'A quantidade é obrigatória.',
            'amount.numeric'  => 'A quantidade tem de ser um número inteiro.',
            'customer.required'  => 'O código do cliente é obrigatório.',
            'customer.numeric'  => 'A código tem de ser um número inteiro.',
            'product.required'  => 'O código do produto é obrigatório.',
            'product.numeric'  => 'A código tem de ser um número inteiro.',
        );
    }


    /**
     * Lista os pedidos com os relacionamentos já carregados com uma consula só.
     * As regras de negocio fica no OrderRepository agora.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->interModel->getAll($this->perPage);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->interModel->rules($request, $this->messages);
        return $this->interModel->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($order)
    {
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $order)
    {
        $this->interModel->rules($request, $this->messages);

        return $this->interModel->update($order, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($order)
    {
        return $this->interModel->delete($order);
    }



    /**
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($order)
    {
        return $this->interModel->restore($order);
    }
}
