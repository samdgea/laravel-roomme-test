<?php

namespace App\EloquentFilters\User;

use Fouladgar\EloquentBuilder\Support\Foundation\Contracts\Filter;
use Illuminate\Database\Eloquent\Builder;

class IsActiveFilter extends Filter
{
    /**
     * Apply the account status condition to the query.
     *
     * @param Builder $builder
     * @param mixed $value
     *
     * @return Builder
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->where('is_active', "=", intval($value));
    }
}
