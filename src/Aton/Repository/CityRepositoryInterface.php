<?php

namespace App\Aton\Repository;

interface CityRepositoryInterface extends RepositoryInterface
{
    public function getAllForView(): array;

    public function getCountryForCity(int $id): array;
}