<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class BeforeFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        return is_null($value) ? $query : $query->before($value);
    }
}
