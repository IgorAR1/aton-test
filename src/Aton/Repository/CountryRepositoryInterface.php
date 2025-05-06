<?php

namespace App\Aton\Repository;

use App\Aton\Entity\Country;

interface CountryRepositoryInterface
{
    public function findAll(): array;
    public function findOne(int $id): array;
    public function getAllForView(): array;
}