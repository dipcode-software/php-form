<?php
namespace PHPForm\Fields;

use Fleshgrinder\Core\Formatter;

use PHPForm\Utils\Attributes;

class BoundField
{
    const LABEL_TEMPLATE = '<label for="{for}"[ {attrs}?]>{contents}[ {required}?]</label>';
    const LABEL_REQUIRED = '<span class="required">*</span>';

    private $form;
    private $field;
    private $name;

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

        return parent::__get($name);
    }

    protected function asWidget($widget = null, array $attrs = null)
    {
        $widget = is_null($widget) ? $this->field->getWidget() : $widget;

        $value = $this->form->getInitialForField($this->field, $this->name);

        if ($this->form->isBound()) {
            $value = $widget->valueFromData($this->form->data, $this->form->files, $this->html_name);
        }

        return $widget->render($this->html_name, $value, $attrs);
    }

    public function labelTag($contents = null, array $attrs = null)
    {
        $contents = is_null($contents) ? $this->label : $contents;

        $widget = $this->field->getWidget();

        if (!is_null($attrs)) {
            $attrs = Attributes::flatatt($attrs);
        }

        return Formatter::format(self::LABEL_TEMPLATE, array(
            "for" => $widget->buildAutoId($this->html_name),
            "attrs" => $attrs,
            "contents" => $contents,
            "required" => $this->field->isRequired() ? $this::LABEL_REQUIRED : null
        ));
    }
}
