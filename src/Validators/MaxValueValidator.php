<?php
/**
 * Validator to check if $value has min length
 */
namespace PHPForm\Validators;

use PHPForm\Validators\BaseValidator;

class MaxValueValidator extends BaseValidator
{
    protected $message = "Ensure this value is less than or equal to {limit}.";
    protected $code = "min_value";

    protected function compare($a, $b)
    {
        return $a > $b;
    }
}
