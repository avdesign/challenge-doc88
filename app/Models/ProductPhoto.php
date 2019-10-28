<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class ProductPhoto extends Model
{
    /**
     * Para ficar fácil de manipular os diretórios e pastas vamos separar assim:
     */
    const BASE_PATH = 'app/public';
    const DIR_PRODUCTS = 'products';
    const PRODUCTS_PATH = self::BASE_PATH . '/' . self::DIR_PRODUCTS;

    protected $fillable = ['file_name', 'product_id', 'cover'];


    /**
     * Uploading multiple files
     * Fazer a criação com os files retornando uma Collection do Eloquent.
     * Se algo der errado remove as fotos
     *
     * @param int $productId
     * @param array $files
     * @return Collection
     * @throws \Exception
     */
    public static function createWithPhotosFiles(int $productId, array $files): Collection
    {
        try{

            self::uploadFiles($productId, $files);
            \DB::beginTransaction();
            $photos = self::createPhotosModels($productId, $files);
            //throw new \Exception('TestErrorUpload');
            \DB::commit();
            return new Collection($photos);

        }catch(\Exception $e){
            self::deleteFiles($productId, $files);
            \DB::rollBack();
            throw new \Exception('ErrorCreate: ProductPhoto', 400);
        }
    }


    /**
     * Alterar a foto de um produto específico
     *
     * @param $product
     * @param array $data
     * @return ProductPhoto
     * @throws \Exception
     */
    public function updateWithPhoto($product, array $data): ProductPhoto
    {
        try {
            $this->checkCover($product, $data['cover']);
            if (isset($data['photo'])) {
                self::uploadPhoto($this->product_id, $data['photo']);
                $data['file_name'] = $data['photo']->hashName();
                /* Fazer backoup da foto atual
                 * $previous = self::photosPath("{$this->product_id}/{$this->photo}");
                 * $tmp = \File::copy(sys_get_temp_dir(), $previous);
                */
            } else {
                $data['file_name'] = $this->photo;
            }
            $data['product_id'] = $this->product_id;

            \DB::beginTransaction();
            $this->deletePhoto($this->file_name);
            $this->fill($data)->save();
            return $this;
            \DB::commit();
        } catch (\Exception $e) {
            if (isset($data['photo'])) {
                $this->deletePhoto($data['photo']);
            }
            \DB::rollBack();
            // Recuperar backoup da foto atual
            throw new \Exception("UpdatePhoto: {$e}", 400);
        }
    }

    public function deleteWithPhoto($product): bool
    {
        try {
            \DB::beginTransaction();
            /* Fazer backoup da foto atual
             * $previous = self::photosPath("{$this->product_id}/{$this->photo}");
             * $tmp = \File::copy(sys_get_temp_dir(), $previous);
            */
            $this->deletePhoto($this->file_name);
            $result = $this->delete();
            \DB::commit();
            return $result;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * Verifica se já existe uma imagem capa ou se precisa alterar o status.
     *
     * @param $product
     * @param $status
     */
    private function checkCover($product, $cover)
    {
        $photos = collect($product->photos);
        $current = $this;
        if ($cover == 1) {
            $photos->each(function ($photo) use($current) {
                $current->id == $photo->id ? $photo->cover = 1 : $photo->cover = 0;
                $photo->save();
            });
        } elseif ($current->cover == 1) {
            $photos->map(function ($photo, $key) {
                if ($key == 0) {
                    $photo->cover = 1;
                    $photo->save();
                }
            });
        }
    }


    /**
     * Fazer upload da foto
     *
     * @param $productId
     * @param UploadedFile $photo
     */
    private static function uploadPhoto($productId, UploadedFile $photo)
    {
        $dir = self::photosDir($productId);
        // Verificar se o driver está no clud ou local
        $filesystemDriver = env('FILESYSTEM_DRIVER', 'local');
        if ($filesystemDriver == 'local') {
            $photo->store($dir, ['disk' => 'public']);
        } else {
            $photo->store($dir, ['disk' => env('FILESYSTEM_DRIVER')]);
        }
    }



    private function deletePhoto($file_name){
        $dir = self::photosDir($this->product_id);
        // Verificar se o driver está no clud ou local
        $filesystemDriver = env('FILESYSTEM_DRIVER', 'local');
        if ($filesystemDriver == 'local') {
            \Storage::disk('public')->delete("{$dir}/{$file_name}");
        } else {
            \Storage::disk(env('FILESYSTEM_DRIVER'))->delete("{$dir}/{$file_name}");
        }

    }



    /**
     * Remover todas a fotos de um produto específico.
     *
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
     * Retornar um array com todas as fotos que foram criadas.
     *
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
     * Gerar caminho da imagem photo_url
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
     * Retorna o dire
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
