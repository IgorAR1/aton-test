<?php

namespace App\Aton\Repository;

use App\Aton\Entity\City;
use App\Aton\Entity\Country;

interface CityRepositoryInterface extends RepositoryInterface
{
    public function getAllForView(): array;

    public function findOne(int $id): ?City;

    public function getCountryForCity(int $id): Country;
}