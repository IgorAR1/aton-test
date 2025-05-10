<?php

namespace App\Aton\Repository;

use App\Aton\Entity\Country;
use App\Aton\Filters\CountriesFilter;
use App\Aton\Sorters\AbstractSorter;
use App\Core\Database\Connection;
use App\Core\Database\QueryBuilder;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    protected static string $table = "countries";

    public function __construct(Connection      $connection,
                                QueryBuilder    $queryBuilder,
                                private CountriesFilter $filter,
                                private AbstractSorter  $sorter)
    {
        parent::__construct($connection, $queryBuilder);
    }

    public function create(array $data): string
    {
        $qb = $this->queryBuilder();

        $this->connection->beginTransaction();

        $sql = $qb->insert(self::$table, ['country' => $data['country']])
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

        $country['id'] = $id;
        $country['country'] = $data['country'];

        $country = array_filter($country, fn($value) => $value !== null);

        $sql = $qb->update(self::$table, $country)
            ->where('id = :id')
            ->getQuery();

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($qb->getQueryParams());

        return $this->connection->commit();
    }

    public function findOne(int $id): ?Country
    {
        $qb = $this->queryBuilder();

        $q = $qb->select('*')
            ->from(static::$table, 'c')
            ->where('c.id = :id')
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

        $q = $qb->select('*')
            ->from(static::$table, 'c')
            ->getQuery();

        $stmt = $this->connection->prepare($q);
        $stmt->execute($qb->getQueryParams());

        $fetched = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->mapEntities($fetched);
    }

    public function getAllForView(): array
    {
        $qb = $this->queryBuilder();

        $qb->select("*")->from(self::$table, 'c');

        $this->filter->apply($qb);
        $this->sorter->apply($qb, ['id', 'country']);

        $q = $qb->getQuery();

        $stmt = $this->connection->prepare($q);
        $stmt->execute($qb->getQueryParams());

        $fetched = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->mapEntities($fetched);
    }

    protected function mapEntity(array $data): Country
    {
       return new Country($data['id'], $data['country']);
    }

}