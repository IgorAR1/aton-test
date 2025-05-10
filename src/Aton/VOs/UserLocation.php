<?php

namespace App\Aton\VOs;

final readonly class UserLocation
{
    public string $city;
    public string $country;

    public function __construct(string $city, string $country){
        $this->city = $city;
        $this->country = $country;
    }
}