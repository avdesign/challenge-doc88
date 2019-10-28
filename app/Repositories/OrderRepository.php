<?php

namespace App\Repositories;


use App\Http\Resources\Api\OrderResource;
use App\Models\Order as Model;
use App\Models\Product;
use App\Models\Customer;
use App\Interfaces\OrderInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class OrderRepository implements OrderInterface
{
    use ValidatesRequests;

    public $model;
    public $request;
    private $product;
    /**
     * @var Customer
     */
    private $customer;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(
        Model $model,
        Request $request,
        Product $product,
        Customer $customer) // Seria o usuário autenticado
    {
        $this->model    = $model;
        $this->request  = $request;
        $this->product  = $product;
        $this->customer = $customer;
    }

    /**
     * ValidatesRequests
     *
     * @param  array $input
     * @param  array $messages
     * @return array
     */
    public function rules($input, $messages, $id='')
    {
        $this->validate($input, $this->model->rules($id), $messages);
    }

    /**
     * Retorna todos od pedidos
     *
     * @param $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($perPage)
    {
        $orders =  $this->model->with('customer', 'product')->paginate($perPage);

        return OrderResource::collection($orders);
    }


    public function setOrder($order)
    {
        $order = $this->model->find($order->id);
        if ($order) {
            return new OrderResource($order);
        }

    }


    /**
     * Create
     *
     * @param $input
     * @return mixed
     */
    public function create($input)
    {
        $product  = $this->product->whereId($input['product'])->orWhere('code', $input['product'])->first();
        if (empty($product)) {
            return response()->json(['Error' => 'Não existe este produto no sistema.'], 400)->content();
        }
        // Se for um usuário autenticado basta: auth()->id();
        $customer = $this->customer->whereId($input['customer'])->orWhere('code', $input['customer'])->first();
        if (empty($customer)) {
            return response()->json('Não existe este cliente no sistema.', 400)->content();
        }
        // Código único da order
        $code = uniqid(date('YmdHis'));
        $data['reference'] = returnNumber($code);
        $data['amount'] = $input['amount'];
        $data['price'] = $product->price;
        $data['total'] = $data['price'] * $data['amount'];
        $data['product_id']  = $product->id;
        $data['customer_id'] = $customer->id;

        $order = $this->model->create($data);
        if ($order) {
            return new OrderResource($order);
        } else {
            $json = $this->responseOrder('Error', 404);
        }

    }


    /**
     * Update
     *
     * @param $order
     * @param $input
     * @return mixed
     */
    public function update($order, $input)
    {
        $product  = $this->product->whereId($input['product'])->orWhere('code', $input['product'])->first();
        if (empty($product)) {
            return response()->json(['Error' => 'Não existe este produto no sistema.'], 400)->content();
        }
        // Se for um usuário autenticado basta: auth()->id();
        $customer = $this->customer->whereId($input['customer'])->orWhere('code', $input['customer'])->first();
        if (empty($customer)) {
            return response()->json('Não existe este cliente no sistema.', 400)->content();
        }

        $order->product_id  = $product->id;
        $order->customer_id = $customer->id;
        $order->amount = $input['amount'];
        $order->price = $product->price;
        $order->total = $product->price * $input['amount'];
        $order->save();

        return new OrderResource($order);

    }




    public function delete($order)
    {
        $delete = $order->delete();
        if ($delete) {
            $json = $this->responseOrder('A ordem foi excluida com sucesso!', 204);
        } else {
            $json = $this->responseOrder('Error', 404);
        }
    }


    public function restore($order)
    {
        $order->restore();

        return new CustomersResource($order);
    }

    private function responseOrder($msg, $sta)
    {
        return response()->json($msg, $sta)->content();

    }


}