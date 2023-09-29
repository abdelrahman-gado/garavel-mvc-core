<?php

declare(strict_types=1);


namespace App\Core\Exceptions;

class NotFoundException extends \Exception
{
    protected $message = "Not Found";
    protected $code = 404;
}