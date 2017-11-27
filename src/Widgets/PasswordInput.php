<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

class PasswordInput extends Input
{
    protected $input_type = 'password';

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
