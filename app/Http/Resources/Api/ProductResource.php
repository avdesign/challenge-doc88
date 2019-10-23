<?php

namespace App\Http\Resources\Api;

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
        $path = env('URL_PHOTOS');
        return [
            //'id' => $this->id,
            'nome' => $this->name,
            'slug' => $this->slug,
            'codigo' => $this->code,
            'preco' => formatReal($this->price),
            'foto' => "{$path}/{$this->photo}",
            'data_criado' => date('d/m/Y', strtotime($this->created_at))
        ];
    }
}
