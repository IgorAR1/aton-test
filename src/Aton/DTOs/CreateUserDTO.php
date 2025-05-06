<?php

namespace App\Aton\DTOs;

readonly final class CreateUserDTO
{
    private string $first_name;
    private ?string $last_name;
    private int $city_id;

    public function __construct(string $first_name, int $city_id, ?string $last_name = null)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->city_id = $city_id;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getCityId(): int
    {
        return $this->city_id;
    }
}