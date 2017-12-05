<?php
/**
 * Validator to check if $value has min length
 */
namespace PHPForm\Validators;

use PHPForm\PHPFormConfig;
use PHPForm\Validators\BaseValidator;

class MinValueValidator extends BaseValidator
{
    protected $code = "min_value";

    public function __construct(int $value, $message = null)
    {
        if (is_null($message)) {
            $message = PHPFormConfig::getIMessage("INVALID_MIN_VALUE");
        }

        parent::__construct($value, $message);
    }

    protected function compare($a, $b)
    {
        return $a < $b;
    }
}
