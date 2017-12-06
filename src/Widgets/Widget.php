<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use Fleshgrinder\Core\Formatter;

use PHPForm\Utils\Attributes;

abstract class Widget
{
    const AUTO_ID_TEMPLATE = "id_{name}[_{index}?]";

    protected $template = "";

    /**
    * @var array Attributes to be added to the widget.
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
    protected function getContext(string $name, $value, array $attrs = null)
    {
        $value = $this->formatValue($value);
        $attrs = $this->buildAttrs($attrs);

        if (!array_key_exists('id', $attrs)) {
            $attrs['id'] = $this->buildAutoId($name);
        }

        return array(
            "name" => htmlentities($name),
            "attrs" => Attributes::flatatt($attrs),
            "value" => is_string($value) ? htmlspecialchars($value) : $value,
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
    * Return defined subwidget.
    *
    * @return array
    */
    public function getSubWidgets(string $name, $value, array $attrs = null)
    {
        return $this->widget;
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
    public function buildAutoId(string $name, int $index = null)
    {
        return Formatter::format(self::AUTO_ID_TEMPLATE, array(
            "name" => $name,
            "index" => $index
        ));
    }
}
