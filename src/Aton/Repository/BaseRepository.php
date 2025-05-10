<?php

namespace App\Aton\Repository;

use App\Core\Database\Connection;
use App\Core\Database\QueryBuilder;

abstract class BaseRepository implements RepositoryInterface
{
    protected \PDO $connection;

    public function __construct(Connection $connection,
                                private QueryBuilder $queryBuilder)
    {
        $this->connection = $connection->getConnection();
    }

    protected static string $table;

    protected function queryBuilder(): QueryBuilder
    {
        return clone $this->queryBuilder;
    }

    abstract protected function mapEntity(array $data): object;
    protected function mapEntities(array $usersData): array
    {
        $result = [];
        foreach ($usersData as $user) {
            $result[] = $this->mapEntity($user);
        }

        return $result;
    }

//    public function findAll(): array
//    {
//        $q = $this->queryBuilder->select("*")
//            ->from(static::$table, 't')
//            ->getQuery();
//
//
//        $stmt = $this->connection->query($q);
//
//        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
//    }

//    public function findOne(int $id): array
//    {
//        $qb = $this->queryBuilder();
//
//        $q = $qb->select("*")
//            ->from(static::$table, 't')
//            ->where('id = :id')
//            ->setParameter('id', $id)
//            ->getQuery();
//
//        $stmt = $this->connection->prepare($q);
//
//        $stmt->execute($qb->getQueryParams());
//
//        return $stmt->fetch(\PDO::FETCH_ASSOC);
//    }

    public function delete(int $id): bool
    {
        $qb = $this->queryBuilder();

        $q = $qb->delete(static::$table, 'id = :id')->setParameter('id', $id)->getQuery();

        $stmt = $this->connection->prepare($q);

        return $stmt->execute($qb->getQueryParams());
    }

//    protected function execute(string $sql, array $params = []): bool
//    {
//        $stmt = $this->connection->prepare($sql);
//
//        return $stmt->execute($params);
//    }


}