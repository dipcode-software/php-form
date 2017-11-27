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

    /**
    * @var bool Mark the widget as required.
    */
    protected $required = false;

    /**
    * @var array Attributes to be added to the widget.
    */
    protected $attrs = array();

    /**
    * @var string The template used to render the HTML.
    */
    protected $template = '';

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

        return Formatter::format($this->template, $context);
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
    public function getContext(string $name, $value, array $attrs = null)
    {
        $value = $this->formatValue($value);
        $attrs = $this->buildAttrs($attrs);

        if (!array_key_exists('id', $attrs)) {
            $attrs['id'] = $this->buildAutoId($name);
        }

        if ($this->required) {
            $attrs['required'] = 'required';
        }

        return array(
            "name" => htmlentities($name),
            "attrs" => Attributes::flatatt($attrs),
            "value" => htmlentities($value)
        );
    }

    /**
     * Format value to be rendered in html.
     *
     * @param mixed $value Value to be formated.
     *
     * @return string
     */
    public function formatValue($value)
    {
        if (empty($value)) {
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
    public function valueFromData($data, $files, string $name)
    {
        if (array_key_exists($name, $data)) {
            return $data[$name];
        }

        return null;
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
    public function buildAttrs(array $extra_attrs = null)
    {
        $attrs = $this->attrs;

        if (!is_null($extra_attrs) && is_array($extra_attrs)) {
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
