<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use PHPForm\PHPFormConfig;

class RadioSelect extends ChoiceWidget
{
    protected $option_inherits_attrs = true;
    protected $selected_attribute = "checked";
    protected $input_type = "radio";

    /**
     * The constructor.
     */
    public function __construct(array $choices = array(), array $attrs = null)
    {
        $this->template = PHPFormConfig::getITemplate("RADIOSELECT");
        $this->template_choice = sprintf(
            PHPFormConfig::getITemplate("RADIOSELECT_ITEM"),
            PHPFormConfig::getITemplate("INPUT")
        );

        parent::__construct($choices, $attrs);
    }
}
