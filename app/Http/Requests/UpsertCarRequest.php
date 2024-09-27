<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertCarRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'make' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1900', 'max:2024'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:65535'],
            'image' => ['sometimes', 'image', 'max:2048'],
        ];
    }
}
