<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * @var null
     */
    private $isCollection;

    public function __construct($resource, $isCollection = null)
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
            'numero' => $this->reference,
            'quantidade' => (int)$this->amount,
            'preco' => formatReal($this->price),
            'total' => formatReal($this->total),
            'data_criado' => date('d/m/Y', strtotime($this->created_at))
        ];

        /* Verifica se já existe na colllection para não repetir */

        if (!$this->isCollection == 'product') {
            $data['pasteis'] = new ProductResource($this->product);
        }

        if (!$this->isCollection == 'customer') {
            $data['cliente'] = new CustomerResource($this->customer);
        }

        return $data;
    }
}
