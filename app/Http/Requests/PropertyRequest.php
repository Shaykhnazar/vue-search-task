<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'price_from' => ['nullable', 'numeric', 'required_with:price_to'],
            'price_to' => ['nullable', 'numeric', 'required_with:price_from'],
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
