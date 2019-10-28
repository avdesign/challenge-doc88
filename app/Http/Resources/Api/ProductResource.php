<?php

namespace App\Http\Resources\Api;

use App\Models\ProductPhoto;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $cover = $this->existCover();
        return [
            'id' => $this->id,
            'nome' => $this->name,
            'slug' => $this->slug,
            'codigo' => $this->code,
            'preco' => formatReal($this->price),
            'foto' => $this->photoUrl($this->id, $cover->file_name),
            'data_criado' => date('d/m/Y', strtotime($this->created_at))
        ];
    }

    /**
     * Gerar caminho da imagem photo_url
     * Verificar se o driver está no cloud ou local
     *
     * @return string
     */
    private function photoUrl($productId, $file_name)
    {
        $path = ProductPhoto::photosDir($productId);
        $filesystemDriver = env('FILESYSTEM_DRIVER', 'local');
        return $filesystemDriver == 'local' ? asset("storage/{$path}/{$file_name}") :
            \Storage::disk($filesystemDriver)->url("{$path}/{$file_name}");
    }

    /**
     * Se não definir ou excluir a foto capa, cria uma aleatoriamente.
     *
     * @return mixed
     */
    private function existCover()
    {
        $photos = $this->photos;
        $photo  = $photos->where('cover', 1)->first();
        if (!$photo) {
            $photo = $photos->sortBy(1)->first();;
        }
        return $photo;
    }

}
