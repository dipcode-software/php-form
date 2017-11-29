<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

class Select extends ChoiceWidget
{
    const TEMPLATE = '<select name="{name}"[ {attrs}?]>{options}</select>';
    const TEMPLATE_CHOICE = '<option value="{value}"[ {attrs}?]>{label}</option>';

    protected $option_inherits_attrs = false;

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
