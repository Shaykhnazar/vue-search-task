<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'price' => ['nullable', 'array', 'min:1', 'max:2'],
            'price.*' => ['numeric'],
            'bedrooms' => ['nullable', 'integer'],
            'bathrooms' => ['nullable', 'integer'],
            'storeys' => ['nullable', 'integer'],
            'garages' => ['nullable', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
