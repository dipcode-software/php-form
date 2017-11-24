<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

abstract class Widget
{
    /**
    * @var bool Mark the widget as required.
    */
    protected $is_required = false;

    /**
    * @var array Attributes for widgets.
    */
    protected $attrs = array();

    /**
     * The constructor.
     */
    public function __construct(array $attrs = null)
    {
        if (!is_null($attrs)) {
            $this->attrs = $attrs;
        }
    }

    /**
     * Abstract method to render html.
     */
    abstract public function render(string $name, string $value, array $attrs = null);

    /**
     * Format value to be rendered in html.
     *
     * @param mixed $value Value to be formated.
     *
     * @return string
     */
    public function formatValue($value)
    {
        if (empty($value) || is_null($value)) {
            return null;
        }

        return (string) $value;
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
    public function valueFromData(array $data, array $files, string $name)
    {
        if (array_key_exists($name, $data)) {
            return $data[$name];
        }

        return null;
    }

    /**
     * Setter for $is_required attribute.
     *
     * @param bool $value Value to be setted.
     */
    public function setIsRequired(bool $value)
    {
        $this->is_required = $value;
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
     * .
     *
     * @param array $attrs .
     */
    public function buildAttrs(array $extra_attrs = null)
    {
        $attrs = $this->attrs;

        if (!is_null($extra_attrs) && is_array($extra_attrs)) {
            $attrs = array_merge($attrs, $extra_attrs);
        }

        return $attrs;
    }
}
