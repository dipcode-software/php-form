<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use PHPForm\PHPFormConfig;

class Textarea extends Widget
{
    /**
     * The constructor.
     */
    public function __construct(array $attrs = null)
    {
        $extra_attrs = array("cols" => 40, "rows" => 5);

        if (!is_null($attrs)) {
            $extra_attrs = array_merge($extra_attrs, $attrs);
        }

        $this->template = PHPFormConfig::getITemplate("TEXTAREA");

        parent::__construct($extra_attrs);
    }
}
