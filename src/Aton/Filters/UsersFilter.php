<?php

namespace App\Aton\Filters;

use App\Core\Database\QueryBuilder;

final class UsersFilter extends AbstractFilter
{
    public function city(QueryBuilder $builder, string $property, string $value): void
    {
        $builder->where("ct.city LIKE :$property")
            ->setParameter("$property", "$value%");;
    }

    public function country(QueryBuilder $builder, string $property, string $value): void
    {
        //TODO: добавить все таки джойн, в билдере сдеалть реплейс если жойны полностью совпадают
        $builder->where("c.country LIKE :$property")
            ->setParameter("$property", "$value%");
    }

//    public function first_name(QueryBuilder $builder, string $property, string $value): void
//    {
//        $builder->where("$property LIKE :$property")->setParameter("$property", "$value%");
//    }
//
//    public function last_name(QueryBuilder $builder, string $property, string $value): void
//    {
//        $builder->where("$property LIKE :$property")->setParameter("$property", "$value%");
//    }

    public function full_name(QueryBuilder $builder, string $property, string $value): void
    {
        $fullName = explode(" ", $value);

        foreach ($fullName as $name) {
            $builder->orWhere("first_name LIKE :value")
                ->orWhere("last_name LIKE :value")
                ->setParameter("value", "%$name%");
        }
//        $builder->where("first_name LIKE :$property")
//            ->orWhere("last_name LIKE :$property")
//            ->setParameter("$property", "%$value%");
    }
}