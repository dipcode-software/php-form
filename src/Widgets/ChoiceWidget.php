<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use PHPForm\Utils\Attributes;

abstract class ChoiceWidget extends Widget
{
    const TEMPLATE_CHOICE = '';
    const INPUT_TYPE = null;

    /**
     * Allow multiple choices being selected.
     * @var boolean
     */
    protected $allow_multiple_selected = false;

    /**
     * Option inherit the attrs of mains widget.
     * @var boolean
     */
    protected $option_inherits_attrs = true;

    /**
     * Attr name when option is selected.
     * @var string
     */
    protected $selected_attribute = "selected";

    /**
     * Valid choices for this widget.
     * @var array
     */
    protected $choices;

    /**
     * The constructor.
     */
    public function __construct(array $choices = array(), array $attrs = null)
    {
        parent::__construct($attrs);

        $this->setChoices($choices);
    }

    /**
     * @param array $choices Choices to be setted.
     */
    public function setChoices(array $choices)
    {
        $this->choices = $choices;
    }

    /**
     * If allow multiple selected, add [] to the end of name.
     *
     * @param  string $name
     * @return string
     */
    protected function buildName(string $name)
    {
        return $this->allow_multiple_selected ? $name . "[]" : $name;
    }

    /**
     * Prepare context to be used on render method.
     *
     * @param string $name  Field name.
     * @param mixed  $value Field value.
     * @param array  $attrs Extra widget attributes.
     *
     * @return array
     */
    protected function getContext(string $name, $value, array $attrs = null)
    {
        $context = parent::getContext($name, $value, $attrs);

        $context["name"] = $this->buildName($name);
        $context["options"] = $this->getOptions($name, $value, $attrs);

        return $context;
    }

    /**
     * Prepare options.
     *
     * @param string $name  Choice name.
     * @param mixed  $value Choice value.
     * @param array  $attrs Extra choice attributes.
     *
     * @return array
     */
    public function getOptions(string $name, $value, array $attrs = null)
    {
        $value = $this->formatValue($value);
        $subwidgets = array();

        $index = 1;
        $has_selected = false;

        foreach ($this->choices as $choice_value => $choice_label) {
            $selected = false;

            if (!$has_selected || $this->allow_multiple_selected) {
                $has_selected = $selected = in_array($choice_value, $value);
            }

            $subwidgets[] = $this->buildOption(
                $name,
                $choice_value,
                $choice_label,
                $selected,
                $index++,
                $attrs
            );
        }

        return $subwidgets;
    }

    /**
     * @param  string     $name
     * @param  mixed      $value
     * @param  string     $label
     * @param  bool       $is_selected
     * @param  int        $index
     * @param  array|null $attrs
     *
     * @return array
     */
    protected function buildOption(
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
            $attrs['id'] = $this->buildAutoId($name, $index);
        }

        if ($is_selected) {
            $attrs[$this->selected_attribute] = $this->selected_attribute;
        }

        return array(
            "for" => $this->buildAutoId($name, $index),
            "type" => static::INPUT_TYPE,
            "name" => $this->buildName($name),
            "value" => $value,
            "label" => $label,
            "attrs" => $attrs,
            "template" => static::TEMPLATE_CHOICE,
        );
    }

    /**
     * Format value to be rendered in html.
     *
     * @param mixed $value Value to be formated.
     *
     * @return array
     */
    protected function formatValue($value)
    {
        if (is_array($value)) {
            $values = [];

            foreach ($value as $v) {
                $values[] = parent::formatValue($v);
            }
        } else {
            $values = !empty($value) ? [parent::formatValue($value)] : [];
        }

        return $values;
    }
}
