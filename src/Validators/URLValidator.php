<?php
/**
 * Validator to check if $value is an valid url
 */
namespace PHPForm\Validators;

use PHPForm\Exceptions\ValidationError;
use PHPForm\PHPFormConfig;
use PHPForm\Validators\Validator;

class URLValidator extends Validator
{
    protected $code = "invalid";

    public function __construct($message = null)
    {
        if (is_null($message)) {
            $message = PHPFormConfig::getIMessage("INVALID_URL");
        }

        parent::__construct($message);
    }

    public function __invoke($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new ValidationError($this->message, $this->code);
        }
    }
}
