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
    protected static string $table = "countries";

    public function __construct(Connection      $connection,
                                QueryBuilder    $queryBuilder,
                                private CountriesFilter $filter,
                                private AbstractSorter  $sorter)
    {
        parent::__construct($connection, $queryBuilder);
    }

    public function create(CreateCountryDTO $data): string
    {
        $qb = $this->queryBuilder();

        $this->connection->beginTransaction();

        $sql = $qb->insert(self::$table, ['country' => $data->getCountry()])
            ->getQuery();

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($qb->getQueryParams());

        $this->connection->commit();

        return $this->connection->lastInsertId();
    }

    public function update(UpdateCountryDTO $data): string
    {
        $qb = $this->queryBuilder();

        $this->connection->beginTransaction();

        $country = $this->findOne($data->getId());
        $country['country'] = $data->getCountry() ?? $country['country'];

        $sql = $qb->update(self::$table, $country)
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

        $qb->select("*")->from(self::$table, 'c');

        $this->filter->apply($qb);
        $this->sorter->apply($qb, ['id', 'country']);

        $q = $qb->getQuery();

        $stmt = $this->connection->prepare($q);
        $stmt->execute($qb->getQueryParams());

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}