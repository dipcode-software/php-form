<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use PHPForm\PHPFormConfig;

class Select extends ChoiceWidget
{
    protected $option_inherits_attrs = false;

    /**
     * The constructor.
     */
    public function __construct(array $choices = array(), array $attrs = null)
    {
        $this->template = PHPFormConfig::getITemplate("SELECT");
        $this->template_choice = PHPFormConfig::getITemplate("SELECT_ITEM");

        parent::__construct($choices, $attrs);
    }

    public function getContext(string $name, $value, array $attrs = null)
    {
        if (is_null($attrs)) {
            $attrs = array();
        }

        if ($this->allow_multiple_selected) {
            $attrs["multiple"] = "multiple";
        }

        return parent::getContext($name, $value, $attrs);
    }
}
