<?php

namespace App\Aton\DTOs;

class UpdateCityDTO
{
    public function __construct(public int $id, public ?string $city, public ?int $country_id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountryId(): int
    {
        return $this->country_id;
    }
}