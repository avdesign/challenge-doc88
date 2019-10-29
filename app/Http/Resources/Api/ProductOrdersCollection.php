<?php

namespace App\Http\Resources\Api;

use App\Models\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductOrdersCollection extends ResourceCollection
{
    /**
     * @var Product
     */
    private $product;

    public function __construct($resource, Product $product)
    {
        parent::__construct($resource);
        $this->product = $product;
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
            'pastel' => new ProductResource($this->product),
            'pedidos' => $this->collection->map(function($order){
                return new OrderResource($order, 'product');
            })
        ];
    }
}
