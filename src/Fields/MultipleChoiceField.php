<?php
/**
 * MultipleChoiceField Class
 */
namespace PHPForm\Fields;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Widgets\SelectMultiple;

class MultipleChoiceField extends ChoiceField
{
    protected $widget = SelectMultiple::class;

    public function isEmpty($value)
    {
        return empty($value);
    }

    public function toNative($value)
    {
        if ($this->isEmpty($value)) {
            return [];
        }

        if (!is_array($value)) {
            throw new ValidationError(msg("INVALID_LIST"), 'invalid_list');
        }

        return array_map('strval', $value);
    }

    protected function validValue($value)
    {
        $keys = array_keys($this->choices);

        return count(array_intersect($value, $keys)) == count($value);
    }
}
