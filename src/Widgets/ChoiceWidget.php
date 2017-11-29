<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use Fleshgrinder\Core\Formatter;

use PHPForm\Utils\Attributes;

abstract class ChoiceWidget extends Widget
{
    const TEMPLATE_OPTION = "";

    protected $allow_multiple_selected = false;
    protected $input_type = null;
    protected $option_inherits_attrs = true;
    protected $selected_attribute = "selected";
    protected $choices;

    /**
     * The constructor.
     */
    public function __construct(array $choices = array(), array $css_classes = null, array $attrs = null)
    {
        parent::__construct($css_classes, $attrs);

        $this->setChoices($choices);
    }

    public function setChoices(array $choices)
    {
        $this->choices = $choices;
    }

    public function getContext(string $name, $value, array $attrs = null)
    {
        $context = parent::getContext($name, $value, $attrs);
        $context["options"] = $this->renderOptions($context["name"], $context["value"], $attrs);

        return $context;
    }

    public function renderOptions(string $name, $value, array $attrs = null)
    {
        $options = "";
        $index = 1;
        $has_selected = false;

        foreach ($this->choices as $choice_value => $choice_label) {
            $selected = false;

            if (!$has_selected || $this->allow_multiple_selected) {
                $selected =  in_array($choice_value, $value);
                $has_selected = true;
            }

            $context = $this->getOptionContext($name, $choice_value, $choice_label, $selected, $index, $attrs);

            $options .= Formatter::format(static::TEMPLATE_OPTION, $context);

            $index++;
        }

        return $options;
    }

    public function getOptionContext(
        string $name,
        $value,
        string $label,
        bool $is_selected,
        int $index,
        array $attrs = null
    ) {
        if (!$this->option_inherits_attrs || is_null($attrs)) {
            $attrs = array();
        }

        if ($this->option_inherits_attrs) {
            $attrs["id"] = $this->buildAutoId($name, $index);
        }

        if ($is_selected) {
            $attrs[$this->selected_attribute] = $this->selected_attribute;
        }

        return array(
            "for" => $this->buildAutoId($name, $index),
            "type" => $this->input_type,
            "name" => $name,
            "value" => htmlentities($value),
            "label" => htmlentities($label),
            "attrs" => Attributes::flatatt($attrs),
        );
    }

    protected function formatValue($value)
    {
        if (is_array($value)) {
            $values = [];

            foreach ($value as $v) {
                $values[] = parent::formatValue($v);
            }
        } else {
            $values = [parent::formatValue($value)];
        }

        return $values;
    }
}
