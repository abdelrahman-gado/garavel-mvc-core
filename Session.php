<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Class Session
 * 
 * @package App\Core
 */
class Session
{

    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flash_messages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flash_messages as $key => &$flashMessage) {
            $flashMessage["removed"] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flash_messages;
    }

    public function setFlash(string $key, string $message): void
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            "removed" => false,
            "value" => $message
        ];
    }


    public function getFlash(string $key): string
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? '';
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        $flash_messages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flash_messages as $key => &$flashMessage) {
            if ($flashMessage['removed']) {
                unset($flash_messages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flash_messages;
    }
}