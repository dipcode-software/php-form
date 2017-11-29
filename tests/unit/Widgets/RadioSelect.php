<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

class RadioSelect extends ChoiceWidget
{
    const TEMPLATE = '<select name="{name}"[ {attrs}?]>{options}</select>';
    const TEMPLATE_OPTION = '<option value="{value}"[ {attrs}?]>{label}</option>';

    protected $option_inherits_attrs = true;
}
