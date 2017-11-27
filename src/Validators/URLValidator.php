<?php
/**
 * Validator to check if $value is an valid email
 */
namespace PHPForm\Validators;

use PHPForm\Validators\Validator;
use PHPForm\Exceptions\ValidationError;

class URLValidator extends Validator
{
    private $message = "Enter a valid URL.";
    private $code = "invalid";

    public function __invoke($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new ValidationError($this->message, $this->code);
        }
    }
}
