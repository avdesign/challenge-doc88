<?php

namespace App\Repositories;


use App\Models\Order as Model;
use App\Interfaces\OrderInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class OrderRepository implements OrderInterface
{
    use ValidatesRequests;

    public $model;
    public $request;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(Request $request, Model $model)
    {
        $this->model   = $model;
        $this->request = $request;

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
        $data  = $this->model->with('customer', 'product')->paginate($perPage);
        return $data;
    }

    /**
     * @param $input
     * @return mixed
     */
    public function create($input)
    {
        return  $this->model->create($input);
    }



}