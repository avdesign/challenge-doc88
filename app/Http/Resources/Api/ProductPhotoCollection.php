<?php

namespace App\Http\Resources\Api;

use App\Models\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductPhotoCollection extends ResourceCollection
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
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'pastel' => new ProductResource($this->product),
            'fotos' => $this->collection->map(function($photo){
                return new ProductPhotoResource($photo, true);
            })
        ];
    }
}
