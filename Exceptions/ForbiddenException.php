<?php

declare(strict_types=1);


namespace App\Core\Exceptions;

class ForbiddenException extends \Exception
{
    protected $message = "You Don't have permission to access this resource";
    protected $code = 403;
}