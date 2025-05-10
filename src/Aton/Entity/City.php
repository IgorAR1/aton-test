<?php

namespace App\Aton\Entity;

class City
{
    private int $id;
    private string $name;
    private Country $country;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setCountry(Country $country): void
    {
        $this->country = $country;
    }
}