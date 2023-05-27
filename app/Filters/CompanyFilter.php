<?php


namespace App\Filters;


use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class CompanyFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if ($value) {
            $countries = json_decode(file_get_contents(base_path('resources/json/countries.json')), true);
            $countryIso = data_get(collect($countries)->filter(function ($item) use ($value) {
                return strtolower($item['name']) === strtolower($value);
            })->first(), 'iso_3166_2');

            $query->where(function ($query) use ($value, $countryIso) {
                $query->where('name', 'like', "%$value%")
                    ->orWhere('auth_string', 'like', "%$value%")
                    ->orWhere('origin_country', $countryIso);
            });
        }
        return $query;
    }
}
