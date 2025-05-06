<?php

namespace App\Core\Http\Controllers;

use App\Core\Http\HtmlResponse;
use App\Core\View\Engine;

abstract class AbstractController
{
    public function __construct(protected Engine $renderEngine)
    {}

    protected function render(string $view, array $args = [], int $status = 200): HtmlResponse
    {
        $html = $this->renderEngine->renderToString($view, $args);

        return new HtmlResponse($html,$status);
    }
}