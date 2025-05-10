<?php

namespace App\Aton\Entity;

use App\Aton\VOs\UserLocation;

class User
{
    readonly int $id;
    private string $firstName;
    private string $lastName;
    private int $city_id;
    private UserLocation $location;

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

    public function getLocation(): UserLocation
    {
        return $this->location;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setLocation(UserLocation $location): void
    {
        $this->location = $location;
    }

    public function getCityId(): int
    {
        return $this->city_id;
    }

    public function setCityId(int $city_id): void
    {
        $this->city_id = $city_id;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    public function getCountry(): string
    {
        return  $this->location->country;
    }
    public function getCity(): string
    {
        return  $this->location->city;
    }
}