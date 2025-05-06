<?php

namespace App\Aton\Filters;

use App\Core\Database\QueryBuilder;

final class UsersFilter extends AbstractFilter
{
    public function city(QueryBuilder $builder, string $property, string $value): void
    {
        $builder->where("$property LIKE :$property")
            ->setParameter("$property", "$value%");;
    }

    public function country(QueryBuilder $builder, string $property, string $value): void
    {
        //TODO: добавить все таки джойн
        $builder->where("$property LIKE :$property")
            ->setParameter("$property", "$value%");

    }

    public function first_name(QueryBuilder $builder, string $property, string $value): void
    {
        $builder->where("$property LIKE :$property")->setParameter("$property", "$value%");
    }

    public function last_name(QueryBuilder $builder, string $property, string $value): void
    {
        $builder->where("$property LIKE :$property")->setParameter("$property", "$value%");
    }
}