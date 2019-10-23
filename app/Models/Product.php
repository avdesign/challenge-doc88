<?php
declare(strict_types=1);

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

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
     * Criar photo principal do produto -
     *
     * @param array $data
     * @return Product
     * @throws \Exception
     */
    public static function createWithPhoto(array $data): Product
    {
        //$data['active'] == true ? $data['active'] = 1 : $data['active'] = 0;

        try {
            self::uploadPhoto($data['photo']);
            $data['photo'] = $data['photo']->hashName();
            \DB::beginTransaction();
            $product = self::create($data);
            \DB::commit();
        } catch (\Exception $e) {
            self::deleteFile($data['photo']);
            \DB::rollBack();
            throw $e;
        }
        return $product;
    }


    public function updateWithPhoto(array $data): Product
    {
        try {
            if (isset($data['photo'])) {
                self::uploadPhoto($data['photo']);
                $this->deletePhoto();
                $data['photo'] = $data['photo']->hashName();
            } else {
                $data['photo'] = $this->photo;
            }

            \DB::beginTransaction();
            $this->fill($data)->save();
            \DB::commit();
        } catch (\Exception $e) {
            if (isset($data['photo'])) {
                self::deleteFile($data['photo']);
            }
            \DB::rollBack();
            throw $e;
        }
        return $this;
    }

    private static function uploadPhoto(UploadedFile $photo)
    {
        $dir = self::photoDir();
        // Verificar se o driver está no clud ou local
        $filesystemDriver = env('FILESYSTEM_DRIVER', 'local');
        if ($filesystemDriver == 'local') {
            $photo->store($dir, ['disk' => 'public']);
        } else {
            $photo->store($dir, ['disk' => env('FILESYSTEM_DRIVER')]);
        }
    }


    private static function deleteFile(UploadedFile $photo)
    {
        $path = self::photoPath();
        $photoPath = "{$path}/{$photo->hashName()}";
        if (file_exists($photoPath)) {
            \File::delete($photoPath);
        }
    }

    private function deletePhoto(){
        $dir = self::photoDir();
        // Verificar se o driver está no clud ou local
        $filesystemDriver = env('FILESYSTEM_DRIVER', 'local');
        if ($filesystemDriver == 'local') {
            \Storage::disk('public')->delete("{$dir}/{$this->photo}");
        } else {
            \Storage::disk(env('FILESYSTEM_DRIVER'))->delete("{$dir}/{$this->photo}");
        }

    }

    private function deletePathFiles(){
        $dir = self::photoDir();
        // Verificar se o driver está no clud ou local
        $filesystemDriver = env('FILESYSTEM_DRIVER', 'local');
        if ($filesystemDriver == 'local') {
            \Storage::disk('public')->delete("{$dir}/{$this->photo}");
        } else {
            \Storage::disk(env('FILESYSTEM_DRIVER'))->delete("{$dir}/{$this->photo}");
        }

    }


    public static function photoPath(){
        $path = self::PRODUCTS_PATH;
        return storage_path($path);
    }

    public static function photoDir()
    {
        $dir = self::DIR_PRODUCTS;
        return $dir;
    }



    public function getPhotoUrlAttribute()
    {
        // Verificar se o driver está no clud ou local
        $filesystemDriver = env('FILESYSTEM_DRIVER', 'local');
        return $filesystemDriver == 'local' ? asset("storage/{$this->photo_url_without_asset}") :
            \Storage::disk($filesystemDriver)->url($this->photo_url_without_asset);
    }

    public function getPhotoUrlWithoutAssetAttribute()
    {
        $path = self::photoDir();
        return "{$path}/{$this->photo}";
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Relations HasMany
     */
    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }
}
