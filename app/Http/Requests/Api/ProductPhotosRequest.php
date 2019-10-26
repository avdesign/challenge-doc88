<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductPhotosRequest extends FormRequest
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
        return !$this->route('photo') ? $this->rulesCreate() : $this->rulesUpdate();
    }

    /**
     * @return array
     */
    private function rulesCreate()
    {
        return [
            'photos' => 'required|array',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:' . (3 * 1024)
        ];
    }

    private function rulesUpdate()
    {
        return [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:' . (3 * 1024)
        ];
    }



    public function messages()
    {
        return [
            'photos.required' => 'O campo Fotos é obrigatório',
            'photos.array' => 'O campo file photos tem que ser com anotações de array.Ex:photos[]',
            'photos.image' => 'O campo Fotos deverá conter uma imagem.',
            'photos.mimes' => 'O campo Fotos deverá conter um arquivo do tipo: jpeg,png,jpg,gif,svg',
            'photos.max' => 'O campo Fotos deverá ter o tamanho de 3 megas',
        ];
    }
}
