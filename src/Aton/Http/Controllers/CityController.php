<?php

namespace App\Aton\Http\Controllers;

use App\Aton\Repository\CityRepository;
use App\Core\Http\Controllers\AbstractController;
use App\Core\View\Engine;
use GuzzleHttp\Psr7\Response;

final class CityController extends AbstractController
{
    public function __construct(Engine $renderEngine, private CityRepository $cityRepository)
    {
        parent::__construct($renderEngine);
    }

    public function index(): Response
    {
        $cities = $this->cityRepository->getAllForView();

        return $this->render("cities", ['cities' => $cities]);
    }
}