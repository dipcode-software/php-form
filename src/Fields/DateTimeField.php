<?php
/**
 * DateTimeField Class
 */
namespace PHPForm\Fields;

use PHPForm\Widgets\DateTimeInput;

class DateTimeField extends Field
{
    protected $widget = DateTimeInput::class;
}
