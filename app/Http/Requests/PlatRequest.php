<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlatRequest extends FormRequest
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
            'name'=>'required|unique:plats,name',
            'category_id'=>'required',
            'price'=>'required',
            'status'=>'required',
            'image'=>'required',

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
            'name.required'=>'le nom du plat est requis',
            'category_id.required'=>'veuillez preciser la category',
            'price.required'=>'le prix du plat est requis',
            'image.required'=>'Veuillez choisir une image',
            'status.required'=>'Veuillez choisir le statut',
        ];
    }
}
