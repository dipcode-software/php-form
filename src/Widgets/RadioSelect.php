<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use PHPForm\PHPFormConfig;

class RadioSelect extends ChoiceWidget
{
    const TEMPLATE = 'radio_select.html';
    const TEMPLATE_CHOICE = 'radio_select_option.html';
    const INPUT_TYPE = 'radio';

    protected $option_inherits_attrs = true;
    protected $selected_attribute = 'checked';
}
