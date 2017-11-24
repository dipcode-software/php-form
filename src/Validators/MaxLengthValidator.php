<?php
/**
 * Validator to check if $value has max length
 */
namespace PHPForm\Validators;

use Fleshgrinder\Core\Formatter;

use PHPForm\Validators\BaseValidator;
use PHPForm\Exceptions\ValidationError;

class MaxLengthValidator extends BaseValidator
{
    protected $message = "Ensure this value has at most {limit} character (it has {value}).";
    protected $code = "max_length";

    protected function cleanValue($value)
    {
        return strlen($value);
    }

    protected function compare($a, $b)
    {
        return $a > $b;
    }
}
