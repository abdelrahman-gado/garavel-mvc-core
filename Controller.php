<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Middlewares\BaseMiddleware;


class Controller
{
    public string $layout = 'main';

    public string $action = '';

    /**
     * Summary of middleware
     * @var BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function render(string $view, $params = []): string
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}