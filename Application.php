<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\DB\Database;
use App\Core\DB\DbModel;


/**
 * Class Application
 * 
 * @package App/Core
 */
class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public static string $ROOT_DIR;

    public static Application $app;

    public ?Controller $controller = null;

    public ?DbModel $user;

    public string $userClass;

    public string $layout = 'main';

    public View $view;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();
        $this->db = new Database($config['db']);
        $this->userClass = $config['userClass'];

        $primaryValue = $this->session->get('user');

        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode(403);
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
        
    }

    /**
     * Get the value of controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * Set the value of controller
     *
     * @return  self
     */
    public function setController($controller): Application
    {
        $this->controller = $controller;

        return $this;
    }


    public function login(DbModel $user): void
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};

        $this->session->set('user', $primaryValue);
    }


    public function logout(): void
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest(): bool
    {
        return !Application::$app->user;
    }
}