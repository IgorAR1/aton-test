<?php

namespace App\Aton\Filters;

use App\Core\Database\QueryBuilder;

final class CountriesFilter extends AbstractFilter
{
    public function country(QueryBuilder $builder, string $property, string $value): void
    {
//       $builder->where("$property LIKE '$value%'");

       $builder->where("$property LIKE :$property");

       $builder->setParameter("$property", "$value%");
    }

    public function id(QueryBuilder $builder, $property, string $value): void
    {
        $builder->where("$property = :$property");

        $builder->setParameter("$property", "$value");
    }
}