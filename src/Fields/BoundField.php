<?php
namespace PHPForm\Fields;

use Fleshgrinder\Core\Formatter;

use PHPForm\PHPFormConfig;
use PHPForm\Utils\Attributes;

class BoundField
{
    private $form;
    private $field;
    private $name;
    private $subwidgets_cache;

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

        if ($name == 'choices') {
            if (!isset($subwidgets_cache)) {
                $subwidgets_cache = $this->getSubWidgets();
            }
            return $subwidgets_cache;
        }

        return parent::__get($name);
    }

    private function getSubWidgets(array $attrs = array())
    {
        $widget = $this->field->getWidget();
        $attrs = $this->buildWidgetAttrs($attrs);

        return $widget->getSubWidgets($this->html_name, $this->getValue(), $attrs);
    }

    protected function asWidget($widget = null, array $attrs = array())
    {
        $widget = is_null($widget) ? $this->field->getWidget() : $widget;

        $attrs = $this->buildWidgetAttrs($attrs);

        return $widget->render($this->html_name, $this->getValue(), $attrs);
    }

    public function labelTag($contents = null, array $attrs = null)
    {
        $contents = is_null($contents) ? $this->label : $contents;

        if (empty($contents)) {
            return "";
        }

        if (!is_null($attrs)) {
            $attrs = Attributes::flatatt($attrs);
        }

        $widget = $this->field->getWidget();

        $label_tpl = PHPFormConfig::getITemplate("LABEL");
        $label_required_tpl = PHPFormConfig::getITemplate("LABEL_REQUIRED");

        return Formatter::format($label_tpl, array(
            "for" => $widget->buildAutoId($this->html_name),
            "attrs" => $attrs,
            "contents" => $contents,
            "required" => $this->field->isRequired() ? $label_required_tpl : null
        ));
    }

    protected function getValue()
    {
        if ($this->form->isBound() && !$this->field->isDisabled()) {
            $widget = $this->field->getWidget();
            $value = $widget->valueFromData($this->form->data, $this->form->files, $this->html_name);
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
