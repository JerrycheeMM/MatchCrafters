<?php

namespace App\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class BeforeFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        if ($value) {
            return $query->where('created_at', '<=', Carbon::parse($value));
        }

        return $query;
    }
}
