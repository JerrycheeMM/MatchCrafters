<?php


namespace App\Filters;


use App\Models\Order;
use App\Models\Permission;
use App\Models\User;
use App\Resources\Statuses\OrderCheckerStatus;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

class OrderFilter
{
    public function apply($orders)
    {
        return QueryBuilder::for($orders)
            ->allowedFilters([
                AllowedFilter::scope('status'),
                AllowedFilter::scope('search'),
                AllowedFilter::custom('before', new BeforeFilter),
                AllowedFilter::custom('after', new AfterFilter),
            ]);
    }
}
