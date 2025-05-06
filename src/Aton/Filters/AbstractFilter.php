<?php

namespace App\Aton\Filters;

use App\Aton\Filters\Exceptions\FilterNotFoundException;
use App\Core\Database\QueryBuilder;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractFilter
{
    public function __construct(protected ServerRequestInterface $request)
    {
    }

    public function apply(QueryBuilder $builder): void
    {
        $filters = $this->getFiltersFromRequest();

        foreach ($filters as $property => $value) {

            if (!method_exists($this, $property)) {
                throw new FilterNotFoundException("Filter {$property} not exists");//Игнорировать?
            }

            $this->{$property}($builder,$property, $value);
        }
    }

    private function getFiltersFromRequest(): array
    {
        $request = $this->request->getQueryParams();

        $filters = [];
        if (isset($request['filter'])) {
            $filters = $request['filter'];
        }

        return $filters;
    }
}