<?php

namespace App\Aton\Http\Controllers;

use App\Aton\DTOs\CreateCountryDTO;
use App\Aton\DTOs\CreateUserDTO;
use App\Aton\DTOs\UpdateCountryDTO;
use App\Aton\DTOs\UpdateUserDTO;
use App\Aton\Repository\CityRepositoryInterface;
use App\Aton\Repository\CountryRepositoryInterface;
use App\Aton\Repository\UserRepositoryInterface;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Validator\ValidatorInterface;
use App\Core\View\Engine;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserController extends AbstractController
{
    public function __construct(Engine                               $renderEngine,
                                protected UserRepositoryInterface    $userRepository,
                                private CityRepositoryInterface      $cityRepository,
                                private ValidatorInterface           $validator)
    {
        parent::__construct($renderEngine);
    }

    public function index(): Response
    {
        $users = $this->userRepository->getAllForView();

        return $this->render("users", ['users' => $users]);
    }

    public function create(): ResponseInterface
    {
        $cities = $this->cityRepository->findAll();

        return $this->render('users_create', ['cities' => $cities]);
    }

    public function edit(int $id): ResponseInterface
    {
        $user = $this->userRepository->findOne($id);

        if (!$user) {
            return $this->render("404", status: 404);
        }

        $cities = $this->cityRepository->findAll();

        return $this->render('users_edit', ['user' => $user, 'cities' => $cities]);
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $request = $request->getParsedBody();

        $errors = $this->validator
            ->setRules([
                'first_name' => ['notBlank', 'string'],
                'last_name' => ['string'],//sometimes нужен
                'city_id' => ['notBlank', 'int'],
            ])
            ->validate($request);

        if (count($errors) > 0) {
            return $this->redirect('/aton/users/create', $errors);
        }

        $data = new CreateUserDTO(...$request);//Дто здесь не нужен

        $this->userRepository->create($data);

        return $this->redirect('/aton/users');
    }

    public function update(int $id, ServerRequestInterface $request): ResponseInterface
    {
        $request = $request->getParsedBody();

        $errors = $this->validator
            ->setRules([
                'first_name' => ['notBlank', 'string'],
                'last_name' => ['string'],//sometimes нужен
                'city_id' => ['notBlank', 'int'],
            ])
            ->validate($request);

        if (count($errors) > 0) {
            return $this->render('users_create', ['errors' => $errors]);
        }

        $data = new UpdateUserDTO($id, ...$request);

        $this->countryRepository->update($data);

        return $this->redirect('/aton/users');
    }

    public function delete(int $id): ResponseInterface
    {
        $this->cityRepository->delete($id);

        return $this->redirect('/aton/users');
    }
}