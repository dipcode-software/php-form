<?php
/**
 * Validator to check if $value has max length
 */
namespace PHPForm\Validators;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Validators\BaseValidator;

class MaxLengthValidator extends BaseValidator
{
    protected $code = "max_length";

    public function __construct(int $value, $message = null)
    {
        if (is_null($message)) {
            $message = msg("INVALID_MAX_LENGTH");
        }

        parent::__construct($value, $message);
    }

    protected function cleanValue($value)
    {
        return strlen($value);
    }

    protected function compare($a, $b)
    {
        return $a > $b;
    }
}
