<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class AfterFilter implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        return is_null($value) ? $query : $query->where('created_at', '>=', $value);
    }
}
