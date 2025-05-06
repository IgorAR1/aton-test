<?php

namespace App\Aton\Repository;

use App\Aton\DTOs\CreateCountryDTO;
use App\Aton\DTOs\UpdateCountryDTO;
use App\Aton\Entity\Country;
use App\Aton\Filters\CountriesFilter;
use App\Aton\Sorters\AbstractSorter;
use App\Core\Database\Connection;
use App\Core\Database\QueryBuilder;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    public function __construct(Connection $connection,
                                private CountriesFilter $filter,
                                private AbstractSorter $sorter,
                                private QueryBuilder $queryBuilder)
    {
        parent::__construct($connection);
    }

    public function create(CreateCountryDTO $data): Country
    {
        $this->connection->beginTransaction();

        $qb = $this->queryBuilder;
        $sql = $qb->insert('countries', ['country'])->setParameters(['country' => $data->getCountry()])->getQuery();

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($qb->getQueryParams());

        $this->connection->commit();

        $country = new Country($this->connection->lastInsertId());
        $country->setCountry($data->country);

        return $country;
    }

    public function update(UpdateCountryDTO $data): Country
    {
        $this->connection->beginTransaction();

        $qb = $this->queryBuilder;
        $sql = $qb->update('countries', ['country'])->where('id = :id')->setParameters(['country' => $data->getCountry()])->getQuery();

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($qb->getQueryParams());

        $this->connection->commit();

        $country = new Country($this->connection->lastInsertId());
        $country->setCountry($data->country);

        return $country;
    }

    public function findAll(): array
    {
        $q = $this->queryBuilder->select("*")
            ->from("countries", 'c')
            ->where('id = :id')
            ->getQuery();

        $stmt = $this->connection->query($q);

        $countries = [];
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $countries[] = $this->hydrateEntity($row);
        }

        return $countries;
    }

    public function findOne(int $id): ?Country
    {
        $q = $this->queryBuilder->select("*")
            ->from("countries", 'c')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $stmt = $this->connection->prepare($q);

        $stmt->execute(['id' => $id]);

        return $this->hydrateEntity($stmt->fetch(\PDO::FETCH_ASSOC));
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

        $countries = [];
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $countries[] = $this->hydrateEntity($row);
        }

        return $countries;
    }

    public function hydrateEntity(array|bool $data): ?Country
    {
        if ($data){
            return new Country(...$data);//Через сеттеры офк
        }

        return null;
    }
}