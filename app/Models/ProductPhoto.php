<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    const BASE_PATH = 'app/public';
    const DIR_PRODUCTS = 'products';

    const PRODUCTS_PATH = self::BASE_PATH . '/' . self::DIR_PRODUCTS;

    protected $fillable = ['file_name','product_id'];


    /**
     * Caminho absoluto até a pasta que vai conter as imagens dos produtos
     *
     * @param $productId
     * @return string
     */
    public static function photosPath($productId)
    {
        $dir = self::PRODUCTS_PATH;
        return storage_path("{$dir}/{$productId}");
    }



    public static function uploadFiles($productId, array $files)
    {
        $dir = self::photosDir($productId);
        $filesystemDriver = env('FILESYSTEM_DRIVER', 'local');

        /** @var UploadedFile $file */
        foreach ($files as $file){

            if ($filesystemDriver == 'local') {
                $file->store($dir, ['disk' => 'public']);
            } else {
                $file->store($dir, ['disk' => env('FILESYSTEM_DRIVER')]);
            }
        }
    }



    /**
     * @param $productId
     * @return string
     */
    public static function photosDir($productId)
    {
        $dir = self::DIR_PRODUCTS;
        return "{$dir}/{$productId}";
    }


    /**
     * Relations BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
