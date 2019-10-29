<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductRequest;
use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\ProductOrdersCollection;

class ProductController extends Controller
{
    private $perPage=5;

    /**
     * Lista todos os produtos com limite por página
     *
     * @return Collection
     */
    public function index()
    {
        $products = Product::paginate($this->perPage);

        return ProductResource::collection($products);
    }

    /**
     * Grava os dados do produto/foto
     *
     * @param ProductRequest $request
     * @return ProductResource
     */
    public function store(ProductRequest $request)
    {
        $product = Product::createWithPhoto($request->all());
        $product->refresh();
        return new ProductResource($product);
    }

    /**
     * Consulta o produto pelo (slug,code,id)
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Alterar dados do produto com validação
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return Product
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->fill($request->all());
        $product->save();

        return $product;
    }

    /**
     * @param Product $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response([], 204);
    }


    /**
     * Retorna os pedidos referente ao produto
     *
     * @param Product $product
     * @return ProductOrdersCollection
     */
    public function orders(Product $product)
    {
        return new ProductOrdersCollection($product->orders, $product);
    }

    /**
     * Restaura o produto
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Product $product)
    {
        $product->restore();

        return new ProductResource($product);
    }
}
