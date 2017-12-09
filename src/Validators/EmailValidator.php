<?php
/**
 * Validator to check if $value is an valid email
 */
namespace PHPForm\Validators;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Validators\Validator;

class EmailValidator extends Validator
{
    protected $code = "invalid";

    public function __construct($message = null)
    {
        if (is_null($message)) {
            $message = msg("INVALID_EMAIL");
        }

        parent::__construct($message);
    }

    public function __invoke($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationError($this->message, $this->code);
        }
    }
}
