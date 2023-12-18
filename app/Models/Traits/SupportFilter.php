<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SupportFilter
{

    public function scopeFilterExactly(Builder $query, ?array $filterFields): Builder
    {
        if (!$filterFields) return $query;

        return $query->where(function (Builder $builder) use ($filterFields) {
            foreach ($filterFields as $field => $value) {
                $builder->when($value, function (Builder $builder) use ($field, $value) {
                    $builder->orWhere($field, $value);
                });
            }
        });
    }
}
