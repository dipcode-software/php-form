<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use Fleshgrinder\Core\Formatter;

use PHPForm\Utils\Attributes;

abstract class Input extends Widget
{
    /**
    * @var string The input type to use for the widget.
    */
    protected $input_type = null;

    /**
     * Renders input widget to HTML.
     *
     * @param string $name    The name to use for the widget.
     * @param mixed  $value   The value to render into the widget.
     * @param array  $attrs   The attributes to use when rendering the widget.
     *
     * @return string
     */
    public function render(string $name, string $value, array $attrs = null)
    {
        $value = $this->formatValue($value);
        $attrs = $this->buildAttrs($attrs);

        if (!is_null($value)) {
            $attrs['value'] = $value;
        }

        Formatter::format('<input type="{type}" name="{name}" {attrs} {required}>', array(
            "type" => $this->input_type,
            "name" => $name,
            "attrs" => Attributes::flatten($attrs),
            "required" => $this->is_required ? 'required' : ''
        ));
    }
}
