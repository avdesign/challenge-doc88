<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    const BASE_PATH = 'app/public';
    const DIR_PRODUCTS = 'products';

    const PRODUCTS_PATH = self::BASE_PATH . '/' . self::DIR_PRODUCTS;

    protected $fillable = ['file_name','product_id'];


    public static function createWithPhotosFiles(int $productId, array $files): Collection
    {
        try{

            self::uploadFiles($productId, $files);
            \DB::beginTransaction();
            $photos = self::createPhotosModels($productId, $files);
            //throw new \Exception('Iniciando exceção!');
            \DB::commit();
            return new Collection($photos);

        }catch(\Exception $e){
            self::deleteFiles($productId, $files);
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param int $productId
     * @param array $files
     */
    private static function deleteFiles(int $productId, array $files)
    {
        /** @var UploadedFile $file */
        foreach ($files as $file) {
            $path = self::photosPath($productId);
            $photoPath = "{$path}/{$file->hashName()}";
            if (file_exists($photoPath)) {
                \File::delete($photoPath);
            }

        }
    }


    /**
     * Verificar se o driver está no cloud ou local
     *
     * @param $productId
     * @param array $files
     */
    public static function uploadFiles(int $productId, array $files)
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
     * @param int $productId
     * @param array $files
     * @return array
     */
    private static function createPhotosModels(int $productId, array $files)
    {
        $photos = [];
        foreach ($files as $file) {
            $photos[] = self::create([
                'file_name' => $file->hashName(),
                'product_id' => $productId
            ]);
        }
        return $photos;
    }

    /**
     * Verificar se o driver está no cloud ou local
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        $path = self::photosDir($this->product_id);
        $filesystemDriver = env('FILESYSTEM_DRIVER', 'local');
        return $filesystemDriver == 'local' ? asset("storage/{$path}/{$this->file_name}") :
            \Storage::disk($filesystemDriver)->url("{$path}/{$this->file_name}");
    }


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
