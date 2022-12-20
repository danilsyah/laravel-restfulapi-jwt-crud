<?php

namespace App\Http\Requests\Category;

use App\Models\Category;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required', 'string', 'max:255', 'unique:category',
            ]
        ];
    }

     // response validation failed
     protected function failedValidation(Validator $validator)
     {
         throw new HttpResponseException(response()->json([
             'errors' => $validator->errors(),
             'status' => true
         ], 422));
     }
}
