<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

class Textarea extends Widget
{
    const TEMPLATE = '<textarea name="{name}" [{attrs}?]>[{value}?]</textarea>';

    /**
     * The constructor.
     */
    public function __construct(array $css_classes = null, array $attrs = null)
    {
        $extra_attrs = array("cols" => 40, "rows" => 5);

        if (!is_null($attrs)) {
            $extra_attrs = array_merge($extra_attrs, $attrs);
        }

        parent::__construct($css_classes, $extra_attrs);
    }
}
