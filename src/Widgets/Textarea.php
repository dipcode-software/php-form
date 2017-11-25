<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

class Textarea extends Widget
{
    /**
    * @var string The input template used to render the HTML.
    */
    protected $template = '<textarea name="{name}" [{attrs}?]>[{value}?]</textarea>';

    /**
     * The constructor.
     */
    public function __construct(array $attrs = null)
    {
        $extra_attrs = array("cols" => 40, "rows" => 5);

        if (!is_null($attrs)) {
            $extra_attrs = array_merge($extra_attrs, $attrs);
        }

        parent::__construct($extra_attrs);
    }
}
