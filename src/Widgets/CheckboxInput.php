<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

class CheckboxInput extends Input
{
    protected $input_type = 'checkbox';

    public function getContext(string $name, $value, array $attrs = null)
    {
        if ($value) {
            $attrs = is_null($attrs) ? array() : $attrs;
            $attrs["checked"] = "checked";
        }

        return parent::getContext($name, $value, $attrs);
    }

    public function valueFromData($data, $files, string $name)
    {
        return array_key_exists($name, $data) ? (bool) $data[$name] : false;
    }
}
