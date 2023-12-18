<?php

namespace App\Models;

use App\Models\Traits\SupportFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use SupportFilter;

    protected $fillable = [
        'name',
        'price',
        'bedrooms',
        'bathrooms',
        'storeys',
        'garages',
    ];

    public function scopeByName(Builder $query, ?string $name): Builder
    {
        if (!$name) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $name . '%');
    }

    public function scopeByPrice(Builder $query, ?int $priceMin, ?int $priceMax): Builder
    {
        if (!$priceMin && !$priceMax) {
            return $query;
        }
        return $query->whereBetween('price', [$priceMin, $priceMax]);
    }
}
