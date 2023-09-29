<?php

declare(strict_types=1);

namespace App\Core\Form;
use App\Core\Model;

/**
 * class Form
 * 
 * @package App\Core\Form
 */
class Form
{
    public static function begin(string $action, $method): Form
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end(): void
    {
        echo '</form>';
    }

    public function field(Model $model, string $attribute): InputField
    {
        return new InputField($model, $attribute);
    }
}