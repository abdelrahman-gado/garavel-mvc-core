<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Class Response
 * 
 * @package App\Core
 */
class Response
{
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }
}