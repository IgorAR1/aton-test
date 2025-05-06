<?php

namespace App\Aton\Http\Controllers;

use App\Core\Http\JsonResponse;

class NewController
{
    public function index()
    {
        return new JsonResponse(['Hello World!']);
    }
}