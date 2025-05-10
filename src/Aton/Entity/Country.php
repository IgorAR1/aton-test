<?php

namespace App\Aton\Entity;

class Country
{
    private int $id;
    private ?string $name;

    public function __construct(int $id, string $country = null)
    {
        $this->name = $country;
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

    public function setName(string $country): void
    {
        $this->name = $country;
    }
}