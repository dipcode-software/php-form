<?php
/**
 * Validator to check if $value has min length
 */
namespace PHPForm\Validators;

use PHPForm\Validators\BaseValidator;

class MaxValueValidator extends BaseValidator
{
    protected $code = "min_value";

    public function __construct(int $value, $message = null)
    {
        if (is_null($message)) {
            $message = msg("INVALID_MAX_VALUE");
        }

        parent::__construct($value, $message);
    }

    protected function compare($a, $b)
    {
        return $a > $b;
    }
}
