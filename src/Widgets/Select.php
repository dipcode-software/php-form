<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use PHPForm\PHPFormConfig;

class Select extends ChoiceWidget
{
    const TEMPLATE = 'select.html';
    const TEMPLATE_CHOICE = 'select_option.html';

    protected $option_inherits_attrs = false;

    public function getContext(string $name, $value, string $label = null, array $attrs = null)
    {
        $context = parent::getContext($name, $value, $label, $attrs);

        if ($this->allow_multiple_selected) {
            $context["attrs"]["multiple"] = "multiple";
        }

        return $context;
    }
}
