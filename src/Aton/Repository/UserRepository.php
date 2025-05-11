<?php

namespace App\Aton\Repository;

use App\Aton\DTOs\CreateCountryDTO;
use App\Aton\DTOs\CreateUserDTO;
use App\Aton\DTOs\UpdateCountryDTO;
use App\Aton\DTOs\UpdateUserDTO;
use App\Aton\Entity\User;
use App\Aton\Filters\CountriesFilter;
use App\Aton\Filters\UsersFilter;
use App\Aton\Sorters\AbstractSorter;
use App\Aton\VOs\UserLocation;
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

    public function create(array $data): string
    {
        $qb = $this->queryBuilder();

        $this->connection->beginTransaction();

        $sql = $qb->insert(self::$table, [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'city_id' => $data['city_id'],
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

        $user['id'] = $id;
        $user['first_name'] = $data['first_name'];
        $user['last_name'] = $data['last_name'];
        $user['city_id'] = $data['city_id'];

        $user = array_filter($user, fn($value) => $value !== null);

        $sql = $qb->update(self::$table, $user)
            ->where('id = :id')
            ->getQuery();

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($qb->getQueryParams());

        return $this->connection->commit();
    }

    public function findOne(int $id): ?User
    {
        $qb = $this->queryBuilder();

        $q = $qb->select('u.*, ct.city, c.country')
            ->from(static::$table, 'u')
            ->join('cities AS ct ON u.city_id = ct.id')
            ->join('countries AS c ON ct.country_id = c.id')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $stmt = $this->connection->prepare($q);
        $stmt->execute($qb->getQueryParams());
        $fetched = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $this->mapEntity($fetched);
    }

    public function getAll(): array
    {
        $qb = $this->queryBuilder();

        $q = $qb->select('u.*, ct.city, c.country')
            ->from(static::$table, 'u')
            ->join('cities AS ct ON u.city_id = ct.id')
            ->join('countries AS c ON ct.country_id = c.id')
            ->getQuery();

        $stmt = $this->connection->prepare($q);
        $stmt->execute($qb->getQueryParams());

        $fetched = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->mapEntities($fetched);
    }

    public function getFiltered(): array
    {
        $qb = $this->queryBuilder();

        $qb->select('u.*, ct.city, c.country')
            ->from(self::$table, 'u')
            ->join('cities AS ct ON u.city_id = ct.id')
            ->join('countries AS c ON ct.country_id = c.id');

        $this->filter->apply($qb);
        $this->sorter->apply($qb, ['id', 'first_name', 'last_name', 'ct.city', 'c.country']);

        $q = $qb->getQuery();

        $stmt = $this->connection->prepare($q);
        $stmt->execute($qb->getQueryParams());

        $fetched = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->mapEntities($fetched);
    }

    protected function mapEntity(array $data): User
    {
        $user = new User($data['id']);

        $location = new UserLocation($data['city'], $data['country']);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setCityId($data['city_id']);
        $user->setLocation($location);

        return $user;
    }
}