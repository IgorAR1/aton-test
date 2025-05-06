<?php

namespace App\Aton\DTOs;

final readonly class CreateCityDTO
{
    public function __construct(public string $city, public int $country_id)
    {
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