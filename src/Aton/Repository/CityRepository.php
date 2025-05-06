<?php

namespace App\Aton\Repository;

use App\Aton\Filters\CitiesFilter;
use App\Aton\Sorters\AbstractSorter;
use App\Blog\Entity\City;
use App\Core\Database\Connection;
use App\Core\Database\QueryBuilder;

class CityRepository extends BaseRepository
{
    public function __construct(Connection $connection,
                                private QueryBuilder $builder,
                                private CitiesFilter $filter,
                                private AbstractSorter $sorter)
    {
        parent::__construct($connection);
    }

    public function findAll(): array
    {
        $q = $this->builder->select("*")
            ->from("cities", 'ct')
            ->where('id = :id')
            ->getQuery();

        $stmt = $this->connection->query($q);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findOne(int $id): ?City
    {
        $q = $this->builder->select("*")
            ->from("cities", 'ct')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $stmt = $this->connection->prepare($q);

        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    public function getAllForView(): array
    {
        $builder = $this->builder;

        $builder->select("ct.id, ct.city, c.country")
            ->from("cities", 'ct')
            ->join("countries AS c ON c.id = ct.country_id");

        $this->filter->apply($builder);
        $this->sorter->apply($builder, ['id', 'country', 'city']);

        $q = $builder->getQuery();

        $stmt = $this->connection->prepare($q);
        $stmt->execute($builder->getQueryParams());

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}