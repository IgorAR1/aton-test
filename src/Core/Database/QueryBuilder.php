<?php

namespace App\Core\Database;

class QueryBuilder
{
    private array $queryParams = [];
    private array $queryParts = [
        'select' => [],
        'from' => [],
        'join' => [],
        'where' => [],
        'group' => [],
        'order' => [],
        'insert' => [],
        'update' => [],
        'delete' => [],
    ];

    private static string $type = '';

    public function select(string $select): self
    {
        self::$type = 'SELECT';

        $this->queryParts['select'][] = $select;

        return $this;
    }

    public function from(string $table, string $alias): self
    {
        $this->queryParts['from'][] = $table . ' AS ' . $alias;

        return $this;
    }

    public function where(string $predicate): self
    {
        $this->andWhere($predicate);

        return $this;
    }

    public function andWhere(string $predicate): self
    {
        $where = &$this->queryParts['where'];

        $where[] = empty($where) ? $predicate : ' AND ' . $predicate;

        return $this;
    }

    public function orWhere(string $predicate): self
    {
        $where = &$this->queryParts['where'];

        $where[] = empty($where) ? $predicate : ' OR ' . $predicate;

        return $this;
    }

    public function join(string $condition): self
    {
        $this->innerJoin($condition);

        return $this;
    }

    public function innerJoin(string $condition): self
    {
        $this->queryParts['join'][] = ' INNER JOIN ' . $condition;

        return $this;
    }

    public function leftJoin(string $condition): self
    {
        $this->queryParts['join'][] = ' LEFT JOIN ' . $condition;

        return $this;
    }

    public function rightJoin(string $condition)
    {
        $this->queryParts['join'][] = ' RIGHT JOIN ' . $condition;

        return $this;
    }

    public function orderBy(string $column, string $order = 'asc'): self
    {
        $this->queryParts['order'][] = $column . ' ' . $order;

        return $this;
    }

//    public function update(string $table, array $columns, array $params = []): self
//    {
//        self::$type = 'UPDATE';
//
//        $set = implode(',', array_map(fn($value) => $value . ' = ' . ':' . $value, $columns));
//
//        $this->queryParts['update'] = $table . ' SET ' . $set;
//
//        $this->setParameters($params);
//
//        return $this;
//    }
    public function update(string $table, array $params): self
    {
        self::$type = 'UPDATE';

        $columns = array_keys($params);

        $set = implode(',', array_map(fn($value) => $value . ' = ' . ':' . $value, $columns));

        $this->queryParts['update'] = $table . ' SET ' . $set;

        $this->setParameters($params);

        return $this;
    }


    public function insert(string $table, array $params): self
    {
        self::$type = 'INSERT';

        $columns = array_keys($params);

        $formatedColumns = '(' . implode(',', $columns) . ')';
        $values = implode(',', array_map(fn($value) => ':' . $value, $columns));

        $this->queryParts['insert'] = $table . $formatedColumns . ' ' . 'VALUES(' . $values . ')';

        $this->setParameters($params);

        return $this;
    }

    public function delete($table, string $predicate = ''): self
    {
        $this->queryParts['delete'][] = $table;

        if ('' !== $predicate) {
            $this->where($predicate);
        }

        return $this;
    }

//    public function findOne(string $table, int $id): string????
//    {
//        return $this->select("*")
//            ->from("cities", 'ct')
//            ->where('id = :id')
//            ->setParameter('id', $id)
//            ->getQuery();
//    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function setParameter(string $key, string $value): self
    {
        $this->queryParams[$key] = $value;

        return $this;
    }

    public function setParameters(array $params): self
    {
        $this->queryParams = array_merge($this->queryParams, $params);

        return $this;
    }

    public function getQuery(): string
    {
        return match (self::$type) {
            'INSERT' => $this->buildQueryForInsert(),
            'UPDATE' => $this->buildQueryForUpdate(),
            'DELETE' => $this->buildQueryForDelete(),
            default => $this->buildQueryForSelect(),
        };
    }

    private function buildQueryForSelect(): string
    {
        $sql = 'SELECT ' . implode(', ', $this->queryParts['select'])
            . ' FROM ' . implode(', ', $this->queryParts['from']);//implode??

        if (!empty($this->queryParts['join'])) {
            $sql .= implode('', $this->queryParts['join']);
        }

        if (!empty($this->queryParts['where'])) {
            $sql .= ' WHERE ' . implode(' ', $this->queryParts['where']);
        }
        if (!empty($this->queryParts['order'])) {
            $sql .= ' ORDER BY ' . implode(', ', $this->queryParts['order']);
        }

        return $sql;
    }


    public function buildQueryForInsert(): string
    {
        return 'INSERT INTO ' . $this->queryParts['insert'];
    }

    public function buildQueryForUpdate(): string
    {
        $sql = 'UPDATE ' . $this->queryParts['update'];

        if (!empty($this->queryParts['where'])) {
            $sql .= ' WHERE ' . implode(' ', $this->queryParts['where']);
        }

        return $sql;
    }

    public function buildQueryForDelete(): string
    {
        $sql = 'DELETE ' . $this->queryParts['delete'];

        if (!empty($this->queryParts['where'])) {
            $sql .= ' WHERE ' . implode('', $this->queryParts['where']);
        }

        return $sql;
    }
}