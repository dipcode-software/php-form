<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

abstract class TemporalInput extends TextInput
{
    /**
    * @var string Format of temporal value.
    */
    protected $format;

    /**
     * The constructor.
     */
    public function __construct(array $attrs = null, string $format = null)
    {
        parent::__construct($attrs);

        $this->format = empty($format) ? $this->format : $format;
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
        if (is_a($value, \DateTime::class)) {
            return date_format($value, $this->format);
        }

        return parent::formatValue($value);
    }
}
