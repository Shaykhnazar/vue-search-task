<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertySearchController extends Controller
{
    public function __invoke(PropertyRequest $propertyRequest)
    {
        return PropertyResource::collection(
            Property::query()
                ->filterExactly([
                    'bedrooms' => $propertyRequest->bedrooms,
                    'bathrooms' => $propertyRequest->bathrooms,
                    'storeys' => $propertyRequest->storeys,
                    'garages' => $propertyRequest->garages,
                ])
                ->byName($propertyRequest->name)
                ->byPrice($propertyRequest->price_from, $propertyRequest->price_to)
                ->get()
        );
    }
}
