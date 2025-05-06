<?php

namespace App\Aton\Repository;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getAllForView(): array;
}