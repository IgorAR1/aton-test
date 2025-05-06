<?php

namespace App\Aton\ServiceProviders;

use App\Aton\Repository\CountryRepository;
use App\Aton\Repository\CountryRepositoryInterface;
use App\Aton\Sorters\AbstractSorter;
use App\Aton\Sorters\Sorter;
use App\Core\Support\ServiceProvider\ServiceProvider;
use App\Core\Validator\Validator;
use App\Core\Validator\ValidatorInterface;

class AppServiceProviders extends ServiceProvider
{
    public function register(): void
    {
//        $this->application->bind(CountryRepositoryInterface::class, function () {
//            return new CountryRepository($this->application->get(Connection::class),$this->application->get(CountriesFilter::class),$this->application->get(SimpleSorter::class));
//        });

        $this->application->bind(CountryRepositoryInterface::class,CountryRepository::class);
        $this->application->bind(AbstractSorter::class,Sorter::class);
        $this->application->bind(ValidatorInterface::class,Validator::class);
    }
}