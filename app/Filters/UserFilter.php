<?php


namespace App\Filters;


use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class UserFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        if ($value) {
            $query->where(function ($query) use ($value) {
                $query->where('name', 'like', "%$value%")
                    ->orWhere('username', 'like', "%$value%")
                    ->orWhereHas('roles', function($role) use ($value) {
                        return $role->where('display_name', 'like', $value);
                    });
            });
        }
        return $query;
    }
}
