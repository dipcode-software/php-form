<?php
/**
 * Validator to check if $value is an valid url
 */
namespace PHPForm\Validators;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Validators\Validator;

class URLValidator extends Validator
{
    protected $message = "Enter a valid URL.";
    protected $code = "invalid";

    public function __invoke($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new ValidationError($this->message, $this->code);
        }
    }
}
