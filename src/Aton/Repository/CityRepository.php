<?php

namespace App\Aton\Repository;

use App\Aton\Entity\City;
use App\Aton\Entity\Country;
use App\Aton\Filters\CitiesFilter;
use App\Aton\Sorters\AbstractSorter;
use App\Core\Database\Connection;
use App\Core\Database\QueryBuilder;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    protected static string $table = "cities";

    public function __construct(Connection             $connection,
                                QueryBuilder           $queryBuilder,
                                private CitiesFilter   $filter,
                                private AbstractSorter $sorter)
    {
        parent::__construct($connection, $queryBuilder);
    }

    public function create(array $data): string
    {
        $qb = $this->queryBuilder();

        $this->connection->beginTransaction();

        $sql = $qb->insert(self::$table, [
            'city' => $data['city'],
            'country_id' => $data['country_id'],
        ])
            ->getQuery();

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($qb->getQueryParams());

        $this->connection->commit();

        return $this->connection->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $qb = $this->queryBuilder();

        $this->connection->beginTransaction();

        $city['id'] = $id;
        $city['city'] = $data['city'];
        $city['country_id'] = $data['country_id'];

        $city = array_filter($city, fn($value) => $value !== null);

        $sql = $qb->update(self::$table, $city)
            ->where('id = :id')
            ->getQuery();

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($qb->getQueryParams());

        return $this->connection->commit();
    }

    public function findOne(int $id): ?City
    {
        $qb = $this->queryBuilder();

        $q = $qb->select('ct.*, c.country')
            ->from(static::$table, 'ct')
            ->join('countries AS c ON ct.country_id = c.id')
            ->where('ct.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $stmt = $this->connection->prepare($q);
        $stmt->execute($qb->getQueryParams());
        $fetched = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $this->mapEntity($fetched);
    }

    public function findAll(): array
    {
        $qb = $this->queryBuilder();

        $q = $qb->select('ct.*, c.country')
            ->from(static::$table, 'ct')
            ->join('countries AS c ON ct.country_id = c.id')
            ->getQuery();

        $stmt = $this->connection->prepare($q);
        $stmt->execute($qb->getQueryParams());

        $fetched = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->mapEntities($fetched);
    }

    public function getAllForView(): array
    {
        $qb = $this->queryBuilder();

        $qb->select("ct.*, c.country")
            ->from(self::$table, 'ct')
            ->join("countries AS c ON c.id = ct.country_id");

        $this->filter->apply($qb);
        $this->sorter->apply($qb, ['id', 'country', 'city']);

        $q = $qb->getQuery();

        $stmt = $this->connection->prepare($q);
        $stmt->execute($qb->getQueryParams());

        $fetched = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        return $this->mapEntities($fetched);
    }

    public function getCountryForCity(int $id): Country
    {
        $qb = $this->queryBuilder();

        $q = $qb->select("ct.id, ct.country_id, c.country")
            ->from(self::$table, 'ct')
            ->join("countries AS c ON c.id = ct.country_id")
            ->where("ct.id = :id")
            ->setParameter('id', $id)
            ->getQuery();

        $stmt = $this->connection->prepare($q);
        $stmt->execute($qb->getQueryParams());
        $fetched = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return new Country($fetched['country']);
    }

    protected function mapEntity(array $data): City
    {
        $city = new City($data['id']);
        $country = new Country($data['country_id'], $data['country']);
        $city->setName($data['city']);
        $city->setCountry($country);

        return $city;
    }

}