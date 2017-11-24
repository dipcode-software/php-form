<?php
/**
 * EmailField Class
 */
namespace PHPForm\Fields;

use PHPForm\Widgets\EmailInput;

class EmailField extends CharField
{
    protected $widget = EmailInput::class;
}
