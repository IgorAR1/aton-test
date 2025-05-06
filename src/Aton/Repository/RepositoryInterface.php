<?php

namespace App\Aton\Repository;

interface RepositoryInterface
{
    public function findAll(): array;

    public function findOne(int $id): array;
}