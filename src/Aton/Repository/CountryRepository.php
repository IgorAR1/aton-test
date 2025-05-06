<?php

namespace App\Aton\Repository;

use App\Aton\DTOs\CreateCountryDTO;
use App\Aton\DTOs\UpdateCountryDTO;
use App\Aton\Filters\CountriesFilter;
use App\Aton\Sorters\AbstractSorter;
use App\Core\Database\Connection;
use App\Core\Database\QueryBuilder;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    public function __construct(Connection              $connection,
                                private CountriesFilter $filter,
                                private AbstractSorter  $sorter,
                                private QueryBuilder    $queryBuilder)
    {
        parent::__construct($connection);
    }

    public function create(CreateCountryDTO $data): string
    {
        $qb = $this->queryBuilder;

        $this->connection->beginTransaction();

        $sql = $qb->insert('countries', ['country' => $data->getCountry()])
            ->getQuery();

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($qb->getQueryParams());

        $this->connection->commit();

        return $this->connection->lastInsertId();
    }

    public function update(UpdateCountryDTO $data): string
    {
        $qb = $this->queryBuilder;

        $this->connection->beginTransaction();

        $country = $this->findOne($data->getId());
        $country['country'] = $data->getCountry() ?? $country['country'];

        $sql = $qb->update('countries', $country)
            ->where('id = :id')
            ->getQuery();

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($qb->getQueryParams());

        $this->connection->commit();

        return $this->connection->lastInsertId();
    }

    public function findAll(): array
    {
        $q = $this->queryBuilder->select("*")
            ->from("countries", 'c')
            ->where('id = :id')
            ->getQuery();

        $stmt = $this->connection->query($q);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findOne(int $id): array
    {
        $q = $this->queryBuilder->select("*")
            ->from("countries", 'c')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $stmt = $this->connection->prepare($q);

        $stmt->execute(['id' => $id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAllForView(): array
    {
        $builder = $this->queryBuilder;
        $builder->select("*")->from("countries", 'c');

        $this->filter->apply($builder);
        $this->sorter->apply($builder, ['id', 'country']);

        $q = $builder->getQuery();

        $stmt = $this->connection->prepare($q);
        $stmt->execute($builder->getQueryParams());

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}