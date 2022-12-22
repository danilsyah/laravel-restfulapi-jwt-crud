<?php

namespace App\Http\Requests\Category;

use App\Models\Category;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @OA\Schema(
 *      title="Update Category request",
 *      description="Update Category request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class UpdateCategoryRequest extends FormRequest
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
            'name' =>[
                'required', 'string', 'max:255', Rule::unique('category')->ignore($this->category)
            ]
        ];
    }

     // ovveride function response validation failed
     protected function failedValidation(Validator $validator)
     {
         throw new HttpResponseException(response()->json([
             'errors' => $validator->errors(),
             'status' => true
         ], 422));
     }
}
