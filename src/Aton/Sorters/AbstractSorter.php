<?php

namespace App\Aton\Sorters;

use App\Core\Database\QueryBuilder;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractSorter
{
    public function __construct(protected ServerRequestInterface $request)
    {
    }

    abstract public function sort(QueryBuilder $builder, string $property, $order = 'asc'): void;

    public function apply(QueryBuilder $builder, array $allowedFields): void// &$sql
    {
        [$property, $order] = $this->getSortParameters();

        if (empty($allowedFields)
            || empty($property)
            || !in_array($property, $allowedFields, true)) {

            return;
        }

        //или
//        if (!in_array($property, $allowedFields, true)) {
//            throw new SorterException('Invalid sort property: ' . $property);
//        }

        $this->sort($builder,$property, $order);
    }

    private function getSortParameters(): array
    {
        $request = $this->request->getQueryParams();

        $property = [];
        $order = 'asc';

        if (isset($request['sort'])) {
            if (isset($request['order'])) {
                $order = $request['order'];
            }
            $property = $request['sort'];
        }

        return [$property, $order];
    }
}