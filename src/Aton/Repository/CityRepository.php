<?php

namespace App\Aton\Repository;

use App\Aton\DTOs\CreateCityDTO;
use App\Aton\DTOs\UpdateCityDTO;
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

    public function create(CreateCityDTO $data): string
    {
        $qb = $this->queryBuilder();

        $this->connection->beginTransaction();

        $sql = $qb->insert(self::$table, ['city' => $data->getCity(), 'country_id' => $data->getCountryId()])
            ->getQuery();

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($qb->getQueryParams());

        $this->connection->commit();

        return $this->connection->lastInsertId();
    }

    public function update(UpdateCityDTO $data): bool
    {
        $qb = $this->queryBuilder();

        $this->connection->beginTransaction();

        $city = $this->findOne($data->getId());

        $city['city'] = $data->getCity() ?? $city['city'];
        $city['country_id'] = $data->getCountryId() ?? $city['city'];

        $sql = $qb->update(self::$table, $city)
            ->where('id = :id')
            ->getQuery();

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($qb->getQueryParams());

        $this->connection->commit();

        return true;
    }

    public function getAllForView(): array
    {
        $qb = $this->queryBuilder();

        $qb->select("ct.id, ct.city, c.country")
            ->from(self::$table, 'ct')
            ->join("countries AS c ON c.id = ct.country_id");

        $this->filter->apply($qb);
        $this->sorter->apply($qb, ['id', 'country', 'city']);

        $q = $qb->getQuery();

        $stmt = $this->connection->prepare($q);
        $stmt->execute($qb->getQueryParams());

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCountryForCity(int $id): array
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

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}