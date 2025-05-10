<?php

namespace App\Aton\Repository;

use App\Aton\Entity\Country;

interface CountryRepositoryInterface extends RepositoryInterface
{
    public function findOne(int $id): ?Country;

    public function getFiltered(): array;
}