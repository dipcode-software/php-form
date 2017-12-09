<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use PHPForm\PHPFormConfig;

class CheckboxSelectMultiple extends ChoiceWidget
{
    const TEMPLATE = 'checkbox_select.html';
    const TEMPLATE_CHOICE = 'checkbox_select_option.html';
    const INPUT_TYPE = 'checkbox';

    protected $allow_multiple_selected = true;
    protected $option_inherits_attrs = true;
    protected $selected_attribute = 'checked';
}
