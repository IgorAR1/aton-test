<?php

namespace App\Aton\Entity;

class Country
{
    private int $id;
    private ?string $country;

    public function __construct(int $id, string $country = null)
    {
        $this->country = $country;
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }
}