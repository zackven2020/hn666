<?php

namespace Dcat\Admin\Form\Field;

trait PlainInput
{
    protected $prepend;

    protected $append;

    public function prepend($string)
    {
        $this->prepend = $string;

        return $this;
    }

    public function append($string)
    {
        $this->append = $string;

        return $this;
    }

    protected function initPlainInput()
    {
        if (empty($this->view)) {
            $this->view = 'admin::form.input';
        }
    }

    protected function defaultAttribute($attribute, $value)
    {
        if (! array_key_exists($attribute, $this->attributes)) {
            $this->attribute($attribute, $value);
        }

        return $this;
    }
}
