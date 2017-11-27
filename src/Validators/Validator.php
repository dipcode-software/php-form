<?php
/**
 * Validator to check if $value has max length
 */
namespace PHPForm\Validators;

abstract class Validator
{
    /**
    * Receive an redefinition of message
    */
    public function __construct($message = null)
    {
        if (isset($message)) {
            $this->message = $message;
        }
    }

    abstract public function __invoke($value);
}
