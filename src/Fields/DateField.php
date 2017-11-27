<?php
/**
 * DateField Class
 */
namespace PHPForm\Fields;

use PHPForm\Widgets\DateInput;

class DateField extends Field
{
    protected $widget = DateInput::class;
}
