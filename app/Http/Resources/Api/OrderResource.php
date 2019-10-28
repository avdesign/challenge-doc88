<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'numero' => $this->reference,
            'pasteis' => new ProductResource($this->product),
            'quantidade' => (int)$this->amount,
            'preco' => formatReal($this->price),
            'total' => formatReal($this->total),
            'cliente' => new CustomersResource($this->customer),
            'data_criado' => $this->created_at
        ];
    }
}
