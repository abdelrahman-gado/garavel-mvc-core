<?php


declare(strict_types=1);

namespace App\Core\Middlewares;

abstract class BaseMiddleware
{

    abstract public function execute();
}