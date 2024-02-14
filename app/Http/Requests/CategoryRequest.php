<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nom_categorie'=>'required|unique:categories,nom_category'

        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(Response()->json([
            'success'=>0,
            'error'=>true,
            'message'=>'Erreur de Validation',
            'errors'=>$validator->errors()
        ]));
    }
    public function messages(): array
    {
        return[
            'nom_categorie.required'=>'le nom du categorie est requis',
            'nom_categorie.unique'=>'le nom du categorie existe déjà',
        ];
    }
}
