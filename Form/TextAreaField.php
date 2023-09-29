<?php

declare(strict_types=1);

namespace App\Core\Form;

use App\Core\Form\BaseField;


class TextAreaField extends BaseField {

    public function renderInput(): string {
        return sprintf('<textarea name="%s" class="form-control%s">%s</textarea>',
        $this->attribute,
        $this->model->hasError($this->attribute) ? ' is-invalid' : '',
        $this->model->{$this->attribute},
    );
    }
}