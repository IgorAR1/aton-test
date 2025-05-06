<?php

namespace App\Aton\Sorters;

use App\Core\Database\QueryBuilder;

class Sorter extends AbstractSorter
{
    public function sort(QueryBuilder $builder, string $property, $order = 'asc'): void
    {
        $builder->orderBy($property, $order);
    }
}