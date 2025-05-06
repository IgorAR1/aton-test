<?php

namespace App\Aton\DTOs;

final readonly class CreateCountryDTO
{
    public string $country;

    public function __construct(string $country)
    {
        $this->country = $country;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}