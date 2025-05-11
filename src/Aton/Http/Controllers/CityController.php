<?php

namespace App\Aton\Http\Controllers;

use App\Aton\Repository\CityRepositoryInterface;
use App\Aton\Repository\CountryRepositoryInterface;
use App\Aton\Service\CityService;
use App\Core\Cache\CacheInterface;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Validator\ValidatorInterface;
//use App\Core\View\Engine;
use Latte\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CityController extends AbstractController
{
    public function __construct(Engine $renderEngine,
                                private CityRepositoryInterface $cityRepository,
                                private CacheInterface     $cache,
                                private CountryRepositoryInterface $countryRepository,
                                private ValidatorInterface $validator)
    {
        parent::__construct($renderEngine);
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $errors = $this->validator->setRules([
            'filter' => ['sometimes', 'array'],
            'sort' => ['sometimes', 'string'],
            'order' => ['sometimes', 'string'],
        ])
            ->validate($queryParams);

        if (count($errors) > 0) {
            return $this->redirect('/aton/cities', $errors);
        }

        $cities = $this->cache->get('cities', function (){
            return $this->cityRepository->getAll();
        });

        return $this->render("cities.latte", ['cities' => $cities]);
    }

    public function create(): ResponseInterface
    {
        $countries = $this->countryRepository->getAll();

        return $this->render('cities_create.latte',['countries' => $countries]);
    }

    public function edit(int $id): ResponseInterface
    {
        $city = $this->cityRepository->findOne($id);

        if (!$city) {
            return $this->render("404", status: 404);
        }

        $countries = $this->countryRepository->getAll();

        return $this->render('cities_edit.latte', ['city' => $city, 'countries' => $countries]);
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $errors = $this->validator
            ->setRules([
                'city' => ['required', 'notBlank', 'string'],
                'country_id' => ['required', 'int']
            ])
            ->validate($data);

        if (count($errors) > 0) {
            return $this->redirect('/aton/cities/create', $errors);
        }

        $this->cityRepository->create($data);

        return $this->redirect('/aton/cities');
    }

    public function update(int $id, ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $errors = $this->validator
            ->setRules([
                'city' => ['required', 'notBlank', 'string'],
                'country_id' => ['required', 'int']
            ])
            ->validate($data);

        if (count($errors) > 0) {
            return $this->redirect("/aton/cities/edit/{$id}", $errors);
        }

        $this->cityRepository->update($id,$data);

        return $this->redirect('/aton/cities');
    }

    public function delete(int $id): ResponseInterface
    {
        $this->cityRepository->delete($id);

        return $this->redirect('/aton/cities');
    }
}