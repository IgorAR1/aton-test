<?php

namespace App\Aton\Http\Controllers;

use App\Aton\DTOs\CreateCityDTO;
use App\Aton\DTOs\UpdateCityDTO;
use App\Aton\Repository\CityRepositoryInterface;
use App\Aton\Repository\CountryRepositoryInterface;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Validator\ValidatorInterface;
use App\Core\View\Engine;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CityController extends AbstractController
{
    public function __construct(Engine $renderEngine,
                                private CityRepositoryInterface $cityRepository,
                                private CountryRepositoryInterface $countryRepository,
                                private ValidatorInterface $validator)
    {
        parent::__construct($renderEngine);
    }

    public function index(): Response
    {
        $cities = $this->cityRepository->getAllForView();

        return $this->render("cities", ['cities' => $cities]);
    }

    public function create(): ResponseInterface
    {
        $countries = $this->countryRepository->findAll();

        return $this->render('cities_create',['countries' => $countries]);
    }

    public function edit(int $id): ResponseInterface
    {
        $city = $this->cityRepository->findOne($id);

        if (!$city) {
            return $this->render("404", status: 404);
        }

        $countries = $this->countryRepository->findAll();

        return $this->render('cities_edit', ['city' => $city, 'countries' => $countries]);
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $request = $request->getParsedBody();

        $errors = $this->validator
            ->setRules([
                'city' => ['required', 'notBlank', 'string'],
                'country_id' => ['required', 'int']
            ])
            ->validate($request);

        if (count($errors) > 0) {
            return $this->redirect('/aton/cities/create', ['errors' => $errors]);
        }

        $data = new CreateCityDTO(...$request);

        $this->cityRepository->create($data);

        return $this->redirect('/aton/cities');
    }

    public function update(int $id, ServerRequestInterface $request): ResponseInterface
    {
        $request = $request->getParsedBody();

        $errors = $this->validator
            ->setRules([
                'city' => ['required', 'notBlank', 'string'],
                'country_id' => ['required', 'int']
            ])
            ->validate($request);

        if (count($errors) > 0) {
            return $this->render('cities_edit', ['errors' => $errors]);
//            return $this->redirect('cities_edit', ['errors' => $errors]);
        }

        $data = new UpdateCityDTO($id, $request['city'],$request['country_id']);//Дто здесь не нужен

        $this->cityRepository->update($data);

        return $this->redirect('/aton/cities');
    }

    public function delete(int $id): ResponseInterface
    {
        $this->cityRepository->delete($id);

        return $this->redirect('/aton/cities');
    }
}