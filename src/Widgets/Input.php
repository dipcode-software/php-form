<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

abstract class Input extends Widget
{
    const TEMPLATE = 'input.html';
    const INPUT_TYPE = null;

    /**
     * Prepare context to be used on render method.
     *
     * @param string $name  Field name.
     * @param mixed  $value Field value.
     * @param mixed  $attrs Extra widget attributes.
     *
     * @return array
     */
    public function getContext(string $name, $value, string $label = null, array $attrs = null)
    {
        $context = parent::getContext($name, $value, $label, $attrs);

        $context["type"] = static::INPUT_TYPE;

        return $context;
    }
}
