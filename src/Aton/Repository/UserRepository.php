<?php

namespace App\Aton\Repository;

use App\Aton\DTOs\CreateCountryDTO;
use App\Aton\DTOs\CreateUserDTO;
use App\Aton\DTOs\UpdateCountryDTO;
use App\Aton\DTOs\UpdateUserDTO;
use App\Aton\Filters\CountriesFilter;
use App\Aton\Filters\UsersFilter;
use App\Aton\Sorters\AbstractSorter;
use App\Core\Database\Connection;
use App\Core\Database\QueryBuilder;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected static string $table = "users";

    public function __construct(Connection             $connection,
                                QueryBuilder           $queryBuilder,
                                private UsersFilter    $filter,
                                private AbstractSorter $sorter)
    {
        parent::__construct($connection, $queryBuilder);
    }

    public function create(CreateUserDTO $data): string
    {
        $qb = $this->queryBuilder();

        $this->connection->beginTransaction();

        $sql = $qb->insert(self::$table, [
            'first_name' => $data->getFirstName(),
            'last_name' => $data->getLastName(),
            'city_id' => $data->getCityId(),
        ])
            ->getQuery();

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($qb->getQueryParams());

        $this->connection->commit();

        return $this->connection->lastInsertId();
    }

    public function update(UpdateUserDTO $data): string
    {
        $qb = $this->queryBuilder();

        $this->connection->beginTransaction();

        $user = $this->findOne($data->getId());
        $user['first_name'] = $data->getFirstName() ?? $user['first_name'];
        $user['last_name'] = $data->getLastName() ?? $user['last_name'];
        $user['city_id'] = $data->getCityId() ?? $user['city_id'];

        $sql = $qb->update(self::$table, $user)
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

        $qb->select('u.*, ct.city, c.country')
            ->from(self::$table, 'u')
            ->join('cities AS ct ON u.city_id = ct.id')
            ->join('countries AS c ON ct.country_id = c.id');

        $this->filter->apply($qb);
        $this->sorter->apply($qb, ['id', 'first_name', 'last_name', 'ct.city', 'c.country']);

        $q = $qb->getQuery();

//        dd($q);
        $stmt = $this->connection->prepare($q);
        $stmt->execute($qb->getQueryParams());

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}