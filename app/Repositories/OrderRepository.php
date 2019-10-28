<?php

namespace App\Repositories;


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

    public function getAll($perPage)
    {
         return Model::with('customer', 'product')->paginate($perPage);
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
        // Se for um usuário autenticado basta: auth()->id();
        $customer = $this->customer->whereId($input['customer'])->orWhere('code', $input['customer'])->first();

        // Código único da order
        $code = uniqid(date('YmdHis'));
        $data['reference'] = returnNumber($code);
        $data['amount'] = $input['amount'];
        $data['price'] = $product->price;
        $data['total'] = $data['price'] * $data['amount'];
        $data['product_id']  = $product->id;
        $data['customer_id'] = $customer->id;

        return  $this->model->create($data);

    }

}