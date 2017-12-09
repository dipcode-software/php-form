<?php
/**
 * Validator to check if $value has min length
 */
namespace PHPForm\Validators;

use PHPForm\Validators\BaseValidator;

class MinLengthValidator extends BaseValidator
{
    protected $code = "min_length";

    public function __construct(int $value, $message = null)
    {
        if (is_null($message)) {
            $message = msg("INVALID_MIN_LENGTH");
        }

        parent::__construct($value, $message);
    }

    protected function cleanValue($value)
    {
        return strlen($value);
    }

    protected function compare($a, $b)
    {
        return $a < $b;
    }
}
