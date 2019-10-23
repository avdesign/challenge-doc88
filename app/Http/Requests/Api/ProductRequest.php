<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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

            dd($this->request->all());
            return [
                'name' => 'required|max:255',
                'price' => 'required|numeric',
                'photo' => 'required',
                //'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:' . (3 * 1024)
            ];
        }

        if ($this->method() == 'PUT') {

            if ( $this->input('photo') ) {
                return [
                    'name' => 'required|max:50',
                    'price' => 'required|numeric',
                    'photo' => 'required',
                    //'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:' . (3 * 1024)
                ];
            } else {
                return [
                    'name' => 'required|max:50',
                    'price' => 'required|numeric'
                ];
            }
        }
    }

    /**
     * Get Messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.max' => 'O nome do produto não deverá conter mais de 50 caracteres.',
            'photo.required' => 'A foto do produto é obrigatória.',
            'price.required' => 'O preço do produto é obrigatório.',
            'price.numeric' => 'O preço é um valor numérico.',
        ];
    }

}
