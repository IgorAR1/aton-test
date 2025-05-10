<?php

namespace App\Aton\Repository;

use App\Aton\Entity\User;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getAllForView(): array;

    public function findOne(int $id): ?User;
}