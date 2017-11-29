<?php
/**
 * DateTimeField Class
 */
namespace PHPForm\Fields;

use PHPForm\Widgets\DateTimeInput;

class DateTimeField extends TemporalField
{
    const FORMAT = "!d-m-Y H:i";

    protected $widget = DateTimeInput::class;

    protected $error_messages = array(
        'invalid' => 'Enter a valid date/time.'
    );
}
