<?php

namespace App\Blog\Entity;

class User
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private City $city;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getCity(City $city): City
    {
        return $this->city;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setCity(City $city): void
    {
        $this->city = $city;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }
}