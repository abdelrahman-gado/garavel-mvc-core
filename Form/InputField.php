<?php

declare(strict_types=1);

namespace App\Core\Form;

use App\Core\Form\BaseField;
use App\Core\Model;


/**
 * class Field
 * 
 * @package App\Core\Form
 */
class InputField extends BaseField
{

    public const TYPE_TEXT = 'text';
    public const TYPE_EMAIL = 'email';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';


    public Model $model;
    public string $attribute;

    public string $type;

    public function __construct(Model $model, string $attribute)
    {
        parent::__construct($model, $attribute);
        $this->type = self::TYPE_TEXT;
    }

    public function __toString()
    {
        return sprintf(
            '<div class="form-group">
                <label>%s</label>
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute),
        );
    }

    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function emailField()
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    public function renderInput(): string
    {
        return sprintf(
            '<input type="%s" name="%s" value="%s" class="form-control%s" placeholder="Enter your %s">',
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
        );
    }
}