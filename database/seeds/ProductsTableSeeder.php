<?php

use App\Models\Product;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class ProductsTableSeeder extends Seeder
{
    /**
     * @var Collection
     */
    private $allFakerPhotos;
    private $fakerPhotoPath = 'app/faker/product_photos';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 15)->create();
        /*
        $this->allFakerPhotos = $this->getFakerPhotos();
        $this->deleteAllPhotosInProductPath();
        factory(Product::class, 30)
            ->make()
            ->each(function(Product $product){
                $product = Product::createWithPhoto($product->toArray() + [
                        'photo' => $this->getUploadedFile()
                    ]);
            });
        */
    }

    private  function deleteAllPhotosInProductPath()
    {
        $path = Product::PRODUCTS_PATH;
        \File::deleteDirectory(storage_path($path), true);
    }

    private function getFakerPhotos(): Collection
    {
        $path = storage_path($this->fakerPhotoPath);
        return collect(\File::allFiles($path));
    }

    private function getUploadedFile(): UploadedFile
    {
        /** @var SplFileInfo $photoFile */
        $photoFile = $this->allFakerPhotos->random();
        $uploadFile = new UploadedFile(
            $photoFile->getRealPath(),
            Str::random(16) . '.' . $photoFile->getExtension()
        );
        //upload da photo
        return $uploadFile;
    }
}
