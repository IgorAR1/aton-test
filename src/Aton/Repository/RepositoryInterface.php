<?php

namespace App\Aton\Repository;

interface RepositoryInterface
{
    public function getAll(): array;
    public function create(array $data): string;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}