<?php
/**
 * BooleanField Class
 */
namespace PHPForm\Fields;

use PHPForm\Exceptions\ValidationError;

class BooleanField extends Field
{
    const FALSE_STRING_VALUES = ['false', '0'];

    /*
    * Tranforms $value into a native php object type
    */
    public function toNative($value)
    {
        if (is_string($value) && in_array($value, $this::FALSE_STRING_VALUES)) {
            $value = false;
        } else {
            $value = (bool)$value;
        }

        return parent::toNative($value);
    }

    /*
    * Extra $value class specific validation
    */
    public function validate($value)
    {
        if (!$value && $this->required) {
            throw new ValidationError($this->error_messages['required'], 'required');
        }
    }
}
