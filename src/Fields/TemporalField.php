<?php
/**
 * DateTimeField Class
 */
namespace PHPForm\Fields;

use PHPForm\Exceptions\ValidationError;

class TemporalField extends Field
{
    /**
     * The constructor.
     */
    public function __construct(array $args = array())
    {
        $this->format = array_key_exists('format', $args) ? $args['format'] : static::FORMAT;

        parent::__construct($args);
    }

    public function isValidDate($date_original, $date_created)
    {
        return $date_created && $date_created->format($this->format) == '!' . $date_original;
    }

    public function toNative($value)
    {
        if (empty($value)) {
            return null;
        }

        $date = date_create_from_format($this->format, $value);

        if (!$date || !$this->isValidDate($value, $date)) {
            throw new ValidationError($this->error_messages['invalid'], 'invalid');
        }

        return $date;
    }
}
