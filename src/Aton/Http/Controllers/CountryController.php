<?php

namespace App\Aton\Http\Controllers;

use App\Aton\DTOs\CreateCountryDTO;
use App\Aton\DTOs\UpdateCountryDTO;
use App\Aton\Repository\CountryRepositoryInterface;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Validator\ValidatorInterface;
//use App\Core\View\Engine;
use GuzzleHttp\Psr7\Response;
use Latte\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CountryController extends AbstractController
{
    public function __construct(Engine $renderEngine,
                                protected CountryRepositoryInterface $countryRepository,
                                private ValidatorInterface $validator)
    {
        parent::__construct($renderEngine);
    }

    public function index(): Response
    {
        $countries = $this->countryRepository->getAllForView();

        return $this->render("countries.latte", ['countries' => $countries]);
    }

    public function create(): ResponseInterface
    {
        return $this->render('countries_create.latte');
    }

    public function edit(int $id): ResponseInterface
    {
        $country = $this->countryRepository->findOne($id);

        if (!$country) {
            return $this->render("404", status: 404);
        }

        return $this->render('countries_edit.latte', ['country' => $country]);
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $errors = $this->validator
            ->setRules(['country' => ['required', 'notBlank', 'string']])
            ->validate($request->getParsedBody());

        if (count($errors) > 0) {
            return $this->redirect('countries_create', ['errors' => $errors]);
        }

        $data = new CreateCountryDTO(...$request->getParsedBody());//Дто здесь не нужен

        $this->countryRepository->create($data);

        return $this->redirect('/aton/countries');
    }

    public function update(int $id, ServerRequestInterface $request): ResponseInterface
    {
        $errors = $this->validator
            ->setRules(['country' => ['string']])
            ->validate($request->getParsedBody());

        if (count($errors) > 0) {
            return $this->redirect('countries_create', $errors);
        }

        $data = new UpdateCountryDTO($id, $request->getParsedBody()['country']);//Дто здесь не нужен

        $this->countryRepository->update($data);

        return $this->redirect('/aton/countries');
    }

    public function delete(int $id): ResponseInterface
    {
        $this->countryRepository->delete($id);

        return $this->redirect('/aton/countries');
    }
}