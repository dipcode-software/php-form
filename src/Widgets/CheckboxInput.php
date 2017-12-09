<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

class CheckboxInput extends Input
{
    const TEMPLATE = 'checkbox.html';
    const INPUT_TYPE = 'checkbox';

    public function getContext(string $name, $value, string $label = null, array $attrs = null)
    {
        if ($value) {
            $attrs = is_null($attrs) ? array() : $attrs;
            $attrs["checked"] = "checked";
        }

        return parent::getContext($name, $value, $label, $attrs);
    }

    public function valueFromData($data, $files, string $name)
    {
        return array_key_exists($name, $data) ? (bool) $data[$name] : false;
    }
}
