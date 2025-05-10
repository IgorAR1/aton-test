<?php

namespace App\Aton\Http\Controllers;

use App\Aton\Repository\CityRepositoryInterface;
use App\Aton\Repository\UserRepositoryInterface;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Validator\ValidatorInterface;

//use App\Core\View\Engine;
use GuzzleHttp\Psr7\Response;
use Latte\Engine;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserController extends AbstractController
{
    public function __construct(Engine                            $renderEngine,
                                protected UserRepositoryInterface $userRepository,
                                private CityRepositoryInterface   $cityRepository,
                                private CacheItemPoolInterface    $cache,
                                private ValidatorInterface        $validator)
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
            return $this->redirect('/aton/users', $errors);
        }

        if (isset($queryParams['filter']) || isset($queryParams['sort'])) {//Условие - заглушка
            $users = $this->userRepository->getAllForView();//Можно сортировать коллекции, но не понятно насколько эьл лучше

            return $this->render("users.latte", ['users' => $users]);
        }

        $cacheItem = $this->cache->getItem('users');

        if ($cacheItem->isHit()) {
            $users = $cacheItem->get();
        } else {
            $users = $this->userRepository->findAll();

            $cacheItem->set($users)->expiresAfter(3600);
            $this->cache->save($cacheItem);
        }

        return $this->render("users.latte", ['users' => $users]);
    }

    public function create(): ResponseInterface
    {
        $cities = $this->cityRepository->findAll();

        return $this->render('user_create.latte', ['cities' => $cities]);
    }

    public function edit(int $id): ResponseInterface
    {
        $user = $this->userRepository->findOne($id);

        if (!$user) {

            return $this->render("404", status: 404);
        }

        $cities = $this->cityRepository->findAll();

        return $this->render('users_edit.latte', ['user' => $user, 'cities' => $cities]);
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $errors = $this->validator
            ->setRules([
                'first_name' => ['notBlank', 'string'],
                'last_name' => ['sometimes', 'string'],
                'city_id' => ['notBlank', 'int'],
            ])
            ->validate($data);

        if (count($errors) > 0) {
            return $this->redirect('/aton/users/create', $errors);
        }

        $this->userRepository->create($data);

        return $this->redirect('/aton/users');
    }

    public function update(int $id, ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $errors = $this->validator
            ->setRules([
                'first_name' => ['sometimes', 'notBlank', 'string'],
                'last_name' => ['sometimes', 'string'],
                'city_id' => ['sometimes', 'notBlank', 'int'],
            ])
            ->validate($data);

        if (count($errors) > 0) {
            return $this->render('users_create', $errors);
        }

        $this->userRepository->update($id, $data);

        return $this->redirect('/aton/users');
    }

    public function delete(int $id): ResponseInterface
    {
        $this->userRepository->delete($id);

        return $this->redirect('/aton/users');
    }
}