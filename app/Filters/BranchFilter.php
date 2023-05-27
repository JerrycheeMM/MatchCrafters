<?php


namespace App\Filters;


use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class BranchFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        if ($value) {
            $query->where(function ($query) use ($value) {
                $query->where('name', 'like', "%$value%")
                    ->orWhere('address', 'like', "%$value%")
                    ->orWhere('branch_code', 'like', "%$value%")
                    ->orWhere('contact_number', 'like', "%$value%")
                    ->orWhere('email', 'like', "%$value%");
            });
        }
        return $query;
    }
}
