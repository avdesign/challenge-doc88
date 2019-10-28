<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Models\Order;
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
        $orders = $this->interModel->getAll($this->perPage);
        return OrderResource::collection($orders);
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
        $order = $this->interModel->create($request->all());

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
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
    public function update(Request $request, Order $order)
    {
        $this->interModel->rules($request, $this->messages);


        /*
        $this->validate($request, [
            'status' => [
                'nullable',
                'in:' .Order::STATUS_APPROVED.','. Order::STATUS_CANCELLED.','.Order::STATUS_SENT,
                new OrderStatusChange($order->status)
            ],
            'payment_link' => [
                'nullable',
                'url',
                new OrderPaymentLinkChange($order->status)
            ]
        ]);
        */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
