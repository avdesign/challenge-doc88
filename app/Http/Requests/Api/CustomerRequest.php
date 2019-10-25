<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'POST') {

            return [
                'password' => 'required|min:4|max:16'
            ];
        }

        if ($this->method() == 'PUT') {
            $password = $this->input('password');
            if (!empty($password) ) {
                return [
                    'password' => 'required|min:4|max:16'
                ];
            }
        }

        ( $this->method() == 'POST' ? $code = '' : $code = $this->get('code') );

        return [
            'email' => "required|email|unique:customers,email,{$code},code",
            'name' => 'required',
            'phone' => 'celular_com_ddd',
            'address' => 'required',
            'district' => 'required',
            'zipcode' => 'formato_cep',
            'birth_date' => 'date_format:d/m/Y'
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'phone.celular_com_ddd' => 'Digite um número de celular válido (99)99999-9999).',
            'address.required' => 'O endereço é obrigatório.',
            'district.required' => 'O bairro é obrigatório.',
            'zipcode.formato_cep' => 'Digite um CEP válido 99999-999.',
            'birth_date.date_format' => 'Digite uma data de nascimento válida.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deverá conter no mínimo 3 caracteres',
            'password.max' => 'A senha não deverá conter mais de 8 caracteres.'
        ];
    }


}
