<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\ProductPhotoCollection;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductPhotosRequest;
use App\Http\Resources\Api\ProductPhotoResource;

use Illuminate\Http\Request;


class ProductPhotoController extends Controller
{
    /**
     * Lista todas as fotos do produto específico.
     *
     * @param Product $product
     * @return ProductPhotoCollection
     */
    public function index(Product $product)
    {
        return new ProductPhotoCollection($product->photos, $product);
    }


    /**
     * Upload das fotos de um produto específico.
     *
     * @param ProductPhotosRequest $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductPhotosRequest $request, Product $product)
    {
        $photos = ProductPhoto::createWithPhotosFiles($product->id, $request->photos);
        return response()->json(new ProductPhotoCollection($photos, $product), 201);
    }

    /**
     * Retorna os dados da foto do produto específico.
     *
     * @param Product $product
     * @param ProductPhoto $photo
     * @return ProductPhotoResource
     */
    public function show(Product $product, ProductPhoto $photo)
    {
        $this->assertProductPhoto($product, $photo);

        return new ProductPhotoResource($photo);
    }

    /**
     * @param ProductPhotosRequest $request
     * @param Product $product
     * @param ProductPhoto $photo
     */
    public function update(ProductPhotosRequest $request, Product $product, ProductPhoto $photo)
    {
        $this->assertProductPhoto($product, $photo);
        $photo = $photo->updateWithPhoto($product, $request->all());
        return new ProductPhotoResource($photo);
    }

    /**
     * Remover uma foto específica
     *
     * @param  \App\Models\ProductPhoto  $productPhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductPhoto $photo)
    {
        $this->assertProductPhoto($product, $photo);
        $photo->deleteWithPhoto($product);

        return response()->json([], 204);
    }


    /**
     * Verifica se o id do product passado esta reacionado com a foto.
     *
     * @param Product $product
     * @param ProductPhoto $photo
     * @return void
     */
    private function assertProductPhoto(Product $product, ProductPhoto $photo): void
    {
        if ($photo->product_id != $product->id) {
            abort(404);
        }
    }
}
