<?php
/**
 * Validator to check if $value is an valid email
 */
namespace PHPForm\Validators;

use PHPForm\Validators\Validator;
use PHPForm\Exceptions\ValidationError;

class EmailValidator extends Validator
{
    protected $message = "Enter a valid email address.";
    protected $code = "invalid";

    public function __invoke($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationError($this->message, $this->code);
        }
    }
}
