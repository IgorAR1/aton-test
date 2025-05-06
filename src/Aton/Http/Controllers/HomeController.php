<?php

namespace App\Aton\Http\Controllers;

use App\Core\Http\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface;

class HomeController extends AbstractController
{
    public function __invoke(): ResponseInterface
    {
        return $this->render('home');
    }
}