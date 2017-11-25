<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

abstract class Input extends Widget
{
    /**
    * @var string The input type to use for the widget.
    */
    protected $input_type = null;

    /**
    * @var string The input template used to render the HTML.
    */
    protected $template = '<input type="{type}" name="{name}" [{attrs}?] [value="{value}?"]/>';

    /**
     * Prepare context to be used on render method.
     *
     * @param string $name  Field name.
     * @param mixed  $value Field value.
     * @param mixed  $attrs Extra widget attributes.
     *
     * @return array
     */
    public function getContext(string $name, $value, array $attrs = null)
    {
        $context = parent::getContext($name, $value, $attrs);
        $context["type"] = $this->input_type;

        return $context;
    }
}
