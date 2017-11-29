<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use PHPForm\Widgets\Input;

class RadioSelect extends ChoiceWidget
{
    const TEMPLATE = '<div>{options}</div>';
    const TEMPLATE_CHOICE = '<label for="{for}">' . Input::TEMPLATE . ' {label}</label>';

    protected $option_inherits_attrs = true;
    protected $selected_attribute = "checked";
    protected $input_type = "radio";
}
