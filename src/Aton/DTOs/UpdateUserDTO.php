<?php

namespace App\Aton\DTOs;

readonly final class UpdateUserDTO
{
    public int $id;
    public ?string $firstName;

    public ?string $lastName;

    public ?int $city_id;

    public function __construct(int $id, string $firstName = null, string $lastName = null, int $city_id = null)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->city_id = $city_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getCityId(): ?int
    {
        return $this->city_id;
    }
}