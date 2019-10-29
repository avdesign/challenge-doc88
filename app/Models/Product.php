<?php
declare(strict_types=1);

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Sluggable, SoftDeletes;

    protected $fillable = ['name', 'code', 'price', 'photo'];

    protected $dates = ['deleted_at'];
    const BASE_PATH = 'app/public';
    const DIR_PRODUCTS = 'products';
    const PRODUCTS_PATH = self::BASE_PATH . '/' . self::DIR_PRODUCTS;

    /**
     * Product Create
     *
     * @param array $data
     * @return Product
     * @throws \Exception
     */
    public static function createWithPhoto(array $data): Product
    {
        $file = $data['photo'];
        try {
            \DB::beginTransaction();
            $data['photo']  = $data['photo']->hashName();
            $product = self::create($data);
            $productId = $product->id;
            self::uploadPhoto($productId, $file);
            $data['file_name']  = $data['photo'];
            $data['product_id'] = $productId;
            $photo = ProductPhoto::create($data);
            \DB::commit();
        } catch (\Exception $e) {
            self::deleteFile($productId, $data['file_name']);
            \DB::rollBack();
            throw new \Exception("UpdatePhoto: {$e}", 400);
        }
        return $product;
    }


    private static function uploadPhoto($productId, UploadedFile $file)
    {
        $dir = self::photoDir();
        // Verificar se o driver está no clud ou local
        $filesystemDriver = env('FILESYSTEM_DRIVER', 'local');
        if ($filesystemDriver == 'local') {
            $file->store("{$dir}/{$productId}", ['disk' => 'public']);
        } else {
            $file->store("{$dir}/{$productId}", ['disk' => env('FILESYSTEM_DRIVER')]);
        }
    }


    /**
     * Remover Foto
     *
     * @param $productId
     * @param UploadedFile $photo
     */
    private static function deleteFile($productId, UploadedFile $photo)
    {
        $path = self::photoPath();

        $photoPath = "{$path}/{$productId}/{$photo->hashName()}";
        if (file_exists($photoPath)) {
            \File::delete($photoPath);
        }
    }

    /**
     * @return string
     */
    public static function photoDir()
    {
        $dir = self::DIR_PRODUCTS;
        return $dir;
    }


    /**
     * @return string
     */
    public static function photoPath(){
        $path = self::PRODUCTS_PATH;
        return storage_path($path);
    }


    /**
     * Gerar um slug com o name do product
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


    /********************** Relationships ******************/
    public function photos(){
        return $this->hasMany(ProductPhoto::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

}
