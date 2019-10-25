<?php
declare(strict_types=1);

use App\Models\Product;
use App\Models\ProductPhoto;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ProductPhotosTableSeeder extends Seeder
{
    /**
     * @var Collection
     */
    private $allFakePhotos;
    private $fakePhotosPath = 'app/faker/product_photos';

    /**
     * Criar fotos faker.
     *
     * @return void
     */
    public function run()
    {
        $this->allFakePhotos = $this->getFakePhotos();
        $products = Product::all();
        $this->deletePhotosFaker();
        $self = $this;
        $products->each(function($product) use($self){
            $self->createPhotoDir($product);
            $self->createPhotosModels($product);
        });
    }

    /**
     * Criar uma collection generica para lidar de forma melhor com os files.
     *
     * @return Collection
     */
    private function getFakePhotos(): Collection
    {
        $path = storage_path($this->fakePhotosPath);
        return collect(\File::allFiles($path));
    }

    /**
     * Cria um diretório com base no id do produto
     *
     * @param Product $product
     */
    private function createPhotoDir(Product $product)
    {
        $path = ProductPhoto::photosPath($product->id);
        \File::makeDirectory($path, 0777, true);
    }

    /**
     * Remover as fotos faker
     */
    private function deletePhotosFaker()
    {
        $path = ProductPhoto::PRODUCTS_PATH;
        \File::deleteDirectory(storage_path($path), true);
    }

    /**
     * Permite criar mais de uma foto por produto.
     * Ex: range(1,5) - cria 5 fotos por produto
     *
     * @param Product $product
     */
    private function createPhotosModels(Product $product)
    {
        foreach (range(1,5) as $v) {
            $this->createPhotoModel($product);
        }
    }

    /**
     * @param Product $product
     */
    private function createPhotoModel(Product $product)
    {
        $photo = ProductPhoto::create([
            'product_id' => $product->id,
            'file_name' => 'image.jpg'
        ]);

        $this->generatePhoto($photo);
    }


    private function generatePhoto(ProductPhoto $photo)
    {
        $photo->file_name = $this->uploadPhoto($photo->product_id);
        $photo->save();
    }

    /**
     *
     *
     * @param $productId
     * @return string
     */
    private function uploadPhoto($productId): string
    {
        /** @var SpfFileInfo $fotoFile */
        $photoFile = $this->allFakePhotos->random();
        $uploadFile = new \Illuminate\Http\UploadedFile(
            $photoFile->getRealPath(),
            Str::random(16). '.' . $photoFile->getExtension()
        );

        ProductPhoto::uploadFiles($productId, [$uploadFile]);

        return $uploadFile->hashName();
    }
}