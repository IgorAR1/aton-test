<?php

namespace App\Aton\Filters;

use App\Core\Database\QueryBuilder;

final class CitiesFilter extends AbstractFilter
{
    public function city(QueryBuilder $builder, string $property, string $value): void
    {
        $builder->where("$property LIKE :$property")
            ->setParameter("$property", "$value%");;
    }

    public function country(QueryBuilder $builder, string $property, string $value): void
    {
        $builder->where("$property LIKE :$property")
            ->setParameter("$property", "$value%");

//        $builder->join("countries AS c ON c.id = ct.country_id")
//            ->where("$property LIKE :$property")
//            ->setParameter("$property", "$value%");
    }
}