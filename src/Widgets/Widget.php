<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use Fleshgrinder\Core\Formatter;

use PHPForm\Utils\Attributes;

abstract class Widget
{
    const AUTO_ID_TEMPLATE = "id_{name}";
    const TEMPLATE = '';

    /**
    * @var bool Mark the widget as required.
    */
    protected $required = false;

    /**
    * @var bool Mark the widget as disabled.
    */
    protected $disabled = false;

    /**
     * @var array Css classes to be added to widget.
     */
    protected $css_classes = array();

    /**
    * @var array Attributes to be added to the widget.
    */
    protected $attrs = array();


    /**
     * The constructor.
     */
    public function __construct(array $css_classes = null, array $attrs = null)
    {
        if (!is_null($css_classes)) {
            $this->css_classes = $css_classes;
        }

        if (!is_null($attrs)) {
            $this->attrs = $attrs;
        }
    }

    /**
     * Renders widget to HTML.
     *
     * @param string $name    The name to use for the widget.
     * @param mixed  $value   The value to render into the widget.
     * @param array  $attrs   The attributes to use when rendering the widget.
     *
     * @return string
     */
    public function render(string $name, $value, array $attrs = null)
    {
        $context = $this->getContext($name, $value, $attrs);

        return Formatter::format(static::TEMPLATE, $context);
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
        $value = $this->formatValue($value);
        $attrs = $this->buildAttrs($attrs);
        $css_classes = $this->buildCssClasses();

        if (!array_key_exists('id', $attrs)) {
            $attrs['id'] = $this->buildAutoId($name);
        }

        if (!empty($css_classes)) {
            $attrs['class'] = $css_classes;
        }

        if ($this->required) {
            $attrs['required'] = 'required';
        }

        if ($this->disabled) {
            $attrs['disabled'] = 'disabled';
        }

        return array(
            "name" => htmlentities($name),
            "attrs" => Attributes::flatatt($attrs),
            "value" => is_string($value) ? htmlentities($value) : $value,
        );
    }

    /**
     * Format value to be rendered in html.
     *
     * @param mixed $value Value to be formated.
     *
     * @return string
     */
    protected function formatValue($value)
    {
        return !empty($value) ? (string) $value : null;
    }

    /**
     * Returns the value determined by the data and name.
     *
     * @param array $data   Array with form data.
     * @param array $files  Array with files form data.
     * @param name  $name   Name of field.
     *
     * @return mixed
     */
    public function valueFromData($data, $files, string $name)
    {
        return array_key_exists($name, $data) ? $data[$name] : null;
    }

    /**
     * Return css classes to be added to each widget.
     * @return string
     */
    private function buildCssClasses()
    {
        return implode(" ", $this->css_classes);
    }

    /**
     * Return css classes to be added to each widget.
     * @return string
     */
    public function setCssClasses(array $css_classes)
    {
        $this->css_classes = array_merge($this->css_classes, $css_classes);
    }

    /**
     * Setter for $required attribute.
     *
     * @param bool $value Value to be setted.
     */
    public function setRequired(bool $value)
    {
        $this->required = $value;
    }

    /**
     * Setter for $disabled attribute.
     *
     * @param bool $value Value to be setted.
     */
    public function setDisabled(bool $value)
    {
        $this->disabled = $value;
    }

    /**
     * Setter for $attrs attribute.
     *
     * @param array $attrs Value to be setted.
     */
    public function setAttrs(array $attrs)
    {
        $this->attrs = array_merge($this->attrs, $attrs);
    }

    /**
     * Join default attrs with $extra_attrs if not null.
     *
     * @param array $extra_attrs.
     *
     * @return array
     */
    private function buildAttrs(array $extra_attrs = null)
    {
        $attrs = $this->attrs;

        if (is_array($extra_attrs)) {
            $attrs = array_merge($attrs, $extra_attrs);
        }

        return $attrs;
    }

    /**
     * Create a id to be rendered in HTML.
     *
     * @param string $name Name of field.
     *
     * @return string
     */
    public function buildAutoId(string $name)
    {
        return Formatter::format(self::AUTO_ID_TEMPLATE, array(
            "name" => $name
        ));
    }
}
