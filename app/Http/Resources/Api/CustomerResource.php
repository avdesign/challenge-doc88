<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            //'id' => $this->id,
            'codigo' => $this->code,
            'nome' => $this->name,
            'email' => $this->email,
            'telefone' => $this->phone,
            'endereco' => $this->address,
            'complemento' => $this->complement,
            'bairro' => $this->district,
            'cep' => $this->zipcode,
            'data_nascimento' => $this->birth_date
        ];
    }
}
