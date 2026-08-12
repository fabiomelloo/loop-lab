<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RunCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return ['code' => ['required', 'string', 'max:10000']];
    }

    public function messages(): array
    {
        return ['code.required' => 'Escreva seu código antes de executar.', 'code.max' => 'O código deve ter no máximo 10.000 caracteres.'];
    }
}
