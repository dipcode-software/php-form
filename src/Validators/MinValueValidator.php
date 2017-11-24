<?php
/**
 * Validator to check if $value has min length
 */
namespace PHPForm\Validators;

use PHPForm\Validators\BaseValidator;

class MinValueValidator extends BaseValidator
{
    protected $message = "Ensure this value is greater than or equal to {limit}.";
    protected $code = "min_value";

    protected function compare($a, $b)
    {
        return $a < $b;
    }
}
