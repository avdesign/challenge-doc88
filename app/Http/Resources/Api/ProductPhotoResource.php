<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductPhotoResource extends JsonResource
{

    /**
     * @var
     */
    private $isCollection;

    /**
     * Verifica se é uma Collection.
     *
     * ProductPhotoResource constructor.
     * @param mixed $resource
     * @param bool $isCollection
     */
    public function __construct($resource, $isCollection = false)
    {
        parent::__construct($resource);

        $this->isCollection = $isCollection;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'capa' => $this->cover,
            'foto_url' => $this->photo_url, #getPhotoUrlAttribute()
            'data_criado' => date('d/m/Y', strtotime($this->created_at)),
        ];

        if (!$this->isCollection) {
            $data['pastel'] = new ProductResource($this->product);
        }

        return $data;
    }
}
