<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

class PasswordInput extends Input
{
    const TEMPLATE = 'password.html';
    const INPUT_TYPE = 'password';

    /**
     * PasswordInput don't render the value.
     *
     * @param mixed $value Value to be formated.
     *
     * @return null
     */
    public function formatValue($value)
    {
        return null;
    }
}
