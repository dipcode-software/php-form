<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use PHPForm\PHPFormConfig;

class CheckboxSelectMultiple extends ChoiceWidget
{
    protected $allow_multiple_selected = true;
    protected $option_inherits_attrs = true;
    protected $selected_attribute = "checked";
    protected $input_type = "checkbox";

    /**
     * The constructor.
     */
    public function __construct(array $choices = array(), array $attrs = null)
    {
        $this->template = PHPFormConfig::getITemplate("CHECKBOX_SELECT_MULTIPLE");
        $this->template_choice = sprintf(
            PHPFormConfig::getITemplate("CHECKBOX_SELECT_MULTIPLE_ITEM"),
            PHPFormConfig::getITemplate("INPUT")
        );

        parent::__construct($choices, $attrs);
    }
}
