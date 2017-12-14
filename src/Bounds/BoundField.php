<?php
namespace PHPForm\Bounds;

use PHPForm\Config;

class BoundField
{
    const TEMPLATE_LABEL = "label.html";

    private $form;
    private $field;
    private $name;
    private $bound_widgets_cache;

    public $html_name;
    public $help_text;
    public $label;

    public function __construct($form, $field, $name)
    {
        $this->form = $form;
        $this->field = $field;
        $this->name = $name;

        $this->html_name = $form->addPrefix($name);
        $this->label = $field->getLabel($name);
        $this->help_text = $field->getHelpText();
    }

    public function __toString()
    {
        return $this->asWidget();
    }

    public function __get($name)
    {
        if ($name == 'errors') {
            return $this->form->getFieldErrors($this->name);
        }

        if ($name == 'has_errors') {
            return $this->form->hasErrors($this->name);
        }

        if ($name == 'label_tag') {
            return $this->labelTag();
        }

        if ($name == 'is_required') {
            return $this->field->isRequired();
        }

        if ($name == 'value') {
            return $this->getValue();
        }

        if ($name == 'options') {
            if (!isset($bound_widgets_cache)) {
                $bound_widgets_cache = $this->getSubWidgets();
            }
            return $bound_widgets_cache;
        }
    }

    private function getSubWidgets(array $attrs = array())
    {
        $bounds = [];

        $attrs = $this->buildWidgetAttrs($attrs);
        $options = $this->field->getWidget()->getOptions($this->html_name, $this->getValue(), $attrs);

        foreach ($options as $option) {
            $bounds[] = new BoundWidget($option);
        }

        return $bounds;
    }

    protected function asWidget($widget = null, array $attrs = array())
    {
        $widget = is_null($widget) ? $this->field->getWidget() : $widget;

        $attrs = $this->buildWidgetAttrs($attrs);

        return $widget->render($this->html_name, $this->getValue(), $this->label, $attrs);
    }

    public function labelTag($contents = null, array $attrs = array())
    {
        $contents = is_null($contents) ? $this->label : $contents;

        if (empty($contents)) {
            return "";
        }

        $widget = $this->field->getWidget();

        $renderer = Config::getInstance()->getRenderer();

        return $renderer->render(self::TEMPLATE_LABEL, array(
            "for" => $widget->buildAutoId($this->html_name),
            "attrs" => $attrs,
            "contents" => $contents,
            "required" => $this->field->isRequired()
        ));
    }

    protected function getValue()
    {
        if ($this->form->isBound() && !$this->field->isDisabled()) {
            $widget = $this->field->getWidget();
            $value = $widget->valueFromData($this->form->getData(), $this->form->getFiles(), $this->html_name);
        } else {
            $value = $this->form->getInitialForField($this->field, $this->name);
        }

        return $value;
    }

    private function buildWidgetAttrs(array $attrs = array())
    {
        $css_classes = $this->form->getCssClasses();

        if ($this->has_errors) {
            $css_classes[] = $this->form->getErrorCssClass();
        }

        if (!empty($css_classes)) {
            $attrs['class'] = implode(" ", $css_classes);
        }

        if ($this->field->isRequired()) {
            $attrs['required'] = 'required';
        }

        if ($this->field->isDisabled()) {
            $attrs['disabled'] = 'disabled';
        }

        return $attrs;
    }
}
