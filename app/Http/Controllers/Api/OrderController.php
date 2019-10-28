<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrderResource;

use Illuminate\Http\Request;



class OrderController extends Controller
{
    private $perPage=5;
    /**
     * Lista os pedidos com os relacionamentos já carregados com uma consula só.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('customer', 'product')->paginate($this->perPage);
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
        //
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
