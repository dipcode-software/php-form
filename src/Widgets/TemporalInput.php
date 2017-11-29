<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

use DateTime;

abstract class TemporalInput extends TextInput
{
    const FORMAT = "";

    /**
     * The constructor.
     */
    public function __construct(string $format = null, array $attrs = null)
    {
        parent::__construct($attrs);

        $this->format = empty($format) ? static::FORMAT : $format;
    }

    /**
     * Format temporal value into defined format.
     *
     * @param mixed $value Value to be formated.
     *
     * @return string
     */
    public function formatValue($value)
    {
        if (is_a($value, DateTime::class)) {
            return date_format($value, $this->format);
        }

        return parent::formatValue($value);
    }
}
