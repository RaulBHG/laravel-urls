<?php

namespace App\Http\Requests;

use App\Http\Responses\BasicResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class StandarRequestAbstract extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [];
    }
    public function messages(): array
    {
        return [];
    }
    protected function failedValidation(Validator $validator)
    {
        $validated = $validator->errors();
        $response  = new BasicResponse(403, $validated->messages(), "Entidad no procesable.");
        throw new HttpResponseException($response->toResponse(request()));
    }
}
