<?php
/**
 * Validator to check if $value has max length
 */
namespace PHPForm\Validators;

interface Validator
{
    public function __invoke($value);
}
