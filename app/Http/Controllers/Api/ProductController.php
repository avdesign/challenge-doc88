<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductRequest;
use App\Http\Resources\Api\ProductResource;

class ProductController extends Controller
{
    private $perPage=15;

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $products = Product::paginate($this->perPage);

        return ProductResource::collection($products);
    }

    public function store(ProductRequest $request)
    {
        dd($request->all());
        $product = Product::create($request->all());
        $product->refresh();
        return $product;
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->fill($request->all());
        $product->save();

        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response([], 204);
    }
}
