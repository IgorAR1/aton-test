<?php

namespace App\Aton\DTOs;

final readonly class UpdateCountryDTO
{
    public int $id;

    public ?string $country;

    public function __construct(int $id, string $country = '')
    {
        $this->id = $id;
        $this->country = $country;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getId(): int
    {
        return $this->id;
    }
}