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
     *
     * @param ProductPhotosRequest $request
     * @param Product $product
     */
    public function store(ProductPhotosRequest $request, Product $product)
    {
        $photos = ProductPhoto::createWithPhotosFiles($product->id, $request->photos);
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
        return new ProductPhotoResource($photo);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductPhoto  $productPhoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductPhoto $productPhoto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductPhoto  $productPhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductPhoto $productPhoto)
    {
        //
    }
}
