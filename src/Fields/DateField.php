<?php
/**
 * DateField Class
 */
namespace PHPForm\Fields;

use PHPForm\Widgets\DateInput;

class DateField extends TemporalField
{
    const FORMAT = "!d-m-Y";

    protected $widget = DateInput::class;

    protected $error_messages = array(
        'invalid' => 'Enter a valid date.'
    );
}
