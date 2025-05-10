<?php

namespace App\Aton\Http\Controllers;

use App\Aton\Repository\CountryRepositoryInterface;
use App\Aton\Service\CountryService;
use App\Core\Cache\CacheItem;
use App\Core\Cache\FileSystem\FileCache;
use App\Core\Cache\FileSystem\SingleFileCache;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Validator\ValidatorInterface;
use GuzzleHttp\Psr7\Response;
use Latte\Engine;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

//use App\Core\View\Engine;

final class CountryController extends AbstractController
{
    public function __construct(Engine                             $renderEngine,
                                private CacheItemPoolInterface     $cache,
                                private CountryRepositoryInterface $countryRepository,
                                private CountryService             $countryService,
                                private ValidatorInterface         $validator)
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
            return $this->redirect('/aton/countries', $errors);
        }

        $countries = $this->countryService->getForView($queryParams);

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
        $data = $request->getParsedBody();
        $errors = $this->validator
            ->setRules(['country' => ['required', 'notBlank', 'string']])
            ->validate($data);

        if (count($errors) > 0) {
            return $this->redirect('/aton/countries/create', $errors);
        }

        $this->countryRepository->create($data);

        return $this->redirect('/aton/countries');
    }

    public function update(int $id, ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $errors = $this->validator
            ->setRules(['country' => ['string']])
            ->validate($data);

        if (count($errors) > 0) {
            return $this->redirect("/aton/countries/edit/{$id}", $errors);
        }

        $this->countryRepository->update($id, $data);

        return $this->redirect('/aton/countries');
    }

    public function delete(int $id): ResponseInterface
    {
        $this->countryRepository->delete($id);

        return $this->redirect('/aton/countries');
    }
}