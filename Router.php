<?php

declare(strict_types=1);

namespace App\Core;
use App\Core\Exceptions\NotFoundException;


/**
 * class Router
 * @package App\Core
 */
class Router
{
    protected array $routes = [];
    public Request $request;

    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
    }

    public function get(string $path, \Closure|string|array $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, \Closure|string|array $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            $this->response->setStatusCode(404);
            throw new NotFoundException();
        }

        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        
        if (is_array($callback)) {

            /** @var \App\Core\Controller $controller */
            $controller = new $callback[0];

            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);
    }

   
}