<?php
/**
 * Validator to check if $value has min length
 */
namespace PHPForm\Validators;

use PHPForm\Validators\BaseValidator;

class MinLengthValidator extends BaseValidator
{
    protected $message = "Ensure this value has at least {limit} character (it has {value}).";
    protected $code = "min_length";

    protected function cleanValue($value)
    {
        return strlen($value);
    }

    protected function compare($a, $b)
    {
        return $a < $b;
    }
}
